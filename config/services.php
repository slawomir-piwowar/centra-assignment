<?php
declare(strict_types=1);

use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Application\Service\BoardService;
use KanbanBoard\Application\Service\BoardServiceInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\GithubApi;
use KanbanBoard\Infrastructure\Repository\BoardRepository;

return [
    GithubApiInterface::class => DI\get(GithubApi::class),
    BoardServiceInterface::class => DI\get(BoardService::class),
    BoardRepositoryInterface::class => DI\get(BoardRepository::class),
];
