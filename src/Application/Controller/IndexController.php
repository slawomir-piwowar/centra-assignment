<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Controller;

use DateTimeInterface;
use KanbanBoard\Application\Provider\RepositoriesProvider\RepositoriesProviderInterface;
use KanbanBoard\Application\Provider\TokenProvider\TokenProviderInterface;
use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Milestone;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 */
class IndexController
{
    private Response $response;
    private TokenProviderInterface $tokenProvider;
    private BoardRepositoryInterface $boardRepository;
    private RepositoriesProviderInterface $repositoriesProvider;

    public function __construct(
        Response $response,
        TokenProviderInterface $tokenProvider,
        BoardRepositoryInterface $boardRepository,
        RepositoriesProviderInterface $repositoriesProvider
    ) {
        $this->response = $response;
        $this->tokenProvider = $tokenProvider;
        $this->boardRepository = $boardRepository;
        $this->repositoriesProvider = $repositoriesProvider;
    }

    public function index(): void
    {
        $token = $this->tokenProvider->provide();

        $milestones = array_map(fn(string $repository): array => [
            array_map(static fn(Milestone $milestone): array => [
                'url' => $milestone->getUrl(),
                'milestone' => $milestone->getTitle(),
                'queued' => array_map(static fn(Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                ], $milestone->queued()),
                'active' => array_map(static fn(Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                    'paused' => $issue->isPaused(),
                    'assignee' => $issue->getAssignee(),
                    'progress' => [
                        'percent' => $issue->getProgress()->getPercent(),
                    ],
                ], $milestone->active()),
                'completed' => array_map(static fn(Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                    'assignee' => $issue->getAssignee(),
                    'closed_at' => $issue->getClosedAt()->format(DateTimeInterface::ISO8601),
                ], $milestone->completed()),
                'progress' => [
                    'percent' => $milestone->getProgress()->getPercent(),
                ],
            ], $this->boardRepository->getByRepository($token, $repository)->getMilestones())
        ], $this->repositoriesProvider->provide());

        $this->render('index/index', [
            'milestones' => array_merge(...array_merge(...$milestones)),
        ]);
    }

    protected function render(string $template, array $context = []): void
    {
        // TODO: inject view engine
        $viewEngine = new Mustache_Engine([
            'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
            'loader' => new Mustache_Loader_FilesystemLoader('../src/views'),
            'cache' => '../var/cache',
        ]);

        $this->response->setContent($viewEngine->render($template, $context));
        $this->response->send();
    }
}
