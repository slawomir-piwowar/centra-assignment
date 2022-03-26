<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Controller;

use KanbanBoard\Application\Provider\TokenProviderInterface;
use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Milestone;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class IndexController
{
    private BoardRepositoryInterface $boardRepository;
    private TokenProviderInterface $tokenProvider;
    private string $repository;

    public function __construct(
        TokenProviderInterface $tokenProvider,
        BoardRepositoryInterface $boardRepository,
        string $repository
    ) {
        $this->boardRepository = $boardRepository;
        $this->tokenProvider = $tokenProvider;
        $this->repository = $repository;
    }

    public function index(): void
    {
        $viewEngine = new Mustache_Engine([
            'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
            'loader' => new Mustache_Loader_FilesystemLoader('../src/views'),
            'cache' => '../var/cache',
        ]);

        echo $viewEngine->render('index/index', [
            'milestones' => array_map(static fn (Milestone $milestone): array => [
                'url' => $milestone->getUrl(),
                'milestone' => $milestone->getTitle(),
                'queued' => array_map(static fn (Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                ], $milestone->queued()),
                'active' => array_map(static fn (Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                    'paused' => $issue->isPaused(),
                    'assignee' => $issue->getAssignee(),
                ], $milestone->active()),
                'completed' => array_map(static fn (Issue $issue): array => [
                    'url' => $issue->getUrl(),
                    'title' => $issue->getTitle(),
                    'assignee' => $issue->getAssignee(),
                ], $milestone->completed()),
                'progress' => [
                    'percent' => $milestone->getProgress()->getPercent(),
                ],
            ], $this->boardRepository->getByRepository(
                $this->tokenProvider->provide(),
                $this->repository,
            )->getMilestones())
        ]);
    }
}
