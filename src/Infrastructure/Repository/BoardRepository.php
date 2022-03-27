<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Repository;

use KanbanBoard\Application\Repository\BoardRepositoryInterface;
use KanbanBoard\Domain\Board;
use KanbanBoard\Domain\Milestone;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;
use KanbanBoard\Infrastructure\Repository\Mapper\MilestoneResponseToDomainMapper;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class BoardRepository implements BoardRepositoryInterface
{
    private GithubApiInterface $githubApi;
    private MilestoneResponseToDomainMapper $milestoneResponseToDomainMapper;

    public function __construct(
        GithubApiInterface $githubApi,
        MilestoneResponseToDomainMapper $milestoneResponseToDomainMapper
    ) {
        $this->githubApi = $githubApi;
        $this->milestoneResponseToDomainMapper = $milestoneResponseToDomainMapper;
    }

    public function getByRepository(string $token, string $repository): Board
    {
        return new Board(
            ...array_map(
                fn (MilestoneResponse $milestoneResponse): Milestone => $this->milestoneResponseToDomainMapper->map(
                    $milestoneResponse,
                    ...$this->githubApi->getIssues($token, $repository, $milestoneResponse->getNumber()),
                ),
                $this->githubApi->getMilestones($token, $repository),
            ),
        );
    }
}
