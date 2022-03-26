<?php
declare(strict_types=1);

use KanbanBoard\Application\Controller\IndexController;
use KanbanBoard\Application\Provider\TokenProvider;
use KanbanBoard\Application\Provider\TokenProviderInterface;
use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\GithubApi;
use KanbanBoard\Infrastructure\Repository\BoardRepository;
use KanbanBoard\Infrastructure\Repository\Mapper\IssueResponseToDomainMapper;
use League\OAuth2\Client\Provider\Github;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

return [
    GithubApiInterface::class => DI\get(GithubApi::class),
    BoardRepositoryInterface::class => DI\get(BoardRepository::class),
    TokenProviderInterface::class => DI\get(TokenProvider::class),
    SessionInterface::class => DI\get(Session::class),

    GithubApi::class => DI\autowire()
        ->constructorParameter('account', DI\env('GH_ACCOUNT')),

    Github::class => DI\autowire()->constructorParameter('options', [
        'clientId' => DI\env('GH_CLIENT_ID'),
        'clientSecret' => DI\env('GH_CLIENT_SECRET'),
    ]),

    Request::class => DI\factory(fn (ContainerInterface $c): Request => Request::createFromGlobals()),

    'paused_labels' => [
        'waiting-for-feedback',
    ],

    IssueResponseToDomainMapper::class => DI\autowire()
        ->constructorParameter('pausedLabels', DI\get('paused_labels')),

    IndexController::class => DI\autowire()
        ->constructorParameter('repository', DI\env('GH_REPOSITORIES'))
];
