<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Controller;

use DateTimeInterface;
use KanbanBoard\Application\Provider\RepositoriesProvider\RepositoriesProviderInterface;
use KanbanBoard\Application\Provider\TokenProvider\TokenProviderInterface;
use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Milestone;
use Symfony\Component\HttpFoundation\Response;

/**
 * @codeCoverageIgnore
 */
class IndexController
{
    private TokenProviderInterface $tokenProvider;
    private BoardRepositoryInterface $boardRepository;
    private RepositoriesProviderInterface $repositoriesProvider;

    public function __construct(
        TokenProviderInterface $tokenProvider,
        BoardRepositoryInterface $boardRepository,
        RepositoriesProviderInterface $repositoriesProvider
    ) {
        $this->tokenProvider = $tokenProvider;
        $this->boardRepository = $boardRepository;
        $this->repositoriesProvider = $repositoriesProvider;
    }

    public function index(): array
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

        return [
            'milestones' => array_merge(...array_merge(...$milestones)),
        ];
    }
}
