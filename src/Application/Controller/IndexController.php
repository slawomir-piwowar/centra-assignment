<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Controller;

use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Milestone;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class IndexController
{
    private BoardRepositoryInterface $boardRepository;

    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function index(): void
    {
        $viewEngine = new Mustache_Engine(array(
            'loader' => new Mustache_Loader_FilesystemLoader('../src/views'),
            'partials_loader' => new Mustache_Loader_FilesystemLoader('../src/views/partials'),
        ));

        echo $viewEngine->render('index', [
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
            ], $this->boardRepository->getByRepository('centra-assignment')->getMilestones())
        ]);
    }
}
