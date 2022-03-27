<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Provider\TokenProvider;

use League\OAuth2\Client\Provider\Github;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TokenProvider implements TokenProviderInterface
{
    private const SESSION_TOKEN_KEY = 'gh-token';

    private Github $github;
    private Request $request;
    private SessionInterface $session;

    public function __construct(Request $request, SessionInterface $session, Github $github)
    {
        $this->github = $github;
        $this->request = $request;
        $this->session = $session;

        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    public function provide(): string
    {
        if ($this->session->has(self::SESSION_TOKEN_KEY)) {
            return $this->session->get(self::SESSION_TOKEN_KEY);
        }

        $code = $this->request->get('code');

        if (null === $code) {
            $redirectUrl = $this->github->getAuthorizationUrl();

            $this->session->set('oauth2state', $this->github->getState());

            $this->redirect($redirectUrl);
        } elseif ($this->session->get('oauth2state') !== $this->request->get('state')) {
            throw new RuntimeException('Invalid oauth state');
        }

        $token = $this->github->getAccessToken('authorization_code', [
            'code' => $code,
        ]);

        $this->session->set(self::SESSION_TOKEN_KEY, $token->getToken());

        return $token->getToken();
    }

    protected function redirect(string $url): void
    {
        $response = new RedirectResponse($url);
        $response->send();
    }
}
