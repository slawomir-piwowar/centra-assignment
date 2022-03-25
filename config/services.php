<?php
declare(strict_types=1);

use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\GithubApi;
use KanbanBoard\Infrastructure\Repository\BoardRepository;
use KanbanBoard\Infrastructure\Repository\Mapper\IssueResponseToDomainMapper;

return [
    GithubApiInterface::class => DI\get(GithubApi::class),
    BoardRepositoryInterface::class => DI\get(BoardRepository::class),

    GithubApi::class => DI\autowire()
        ->constructorParameter('account', DI\env('GH_ACCOUNT'))
        ->constructorParameter('token', DI\env('TEMP_GH_TOKEN')),

    'paused_labels' => [
        'waiting-for-feedback',
    ],

    IssueResponseToDomainMapper::class => DI\autowire()
        ->constructorParameter('pausedLabels', DI\get('paused_labels'))
];
