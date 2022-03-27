<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Repository\Mapper;

use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Milestone;
use KanbanBoard\Domain\Progress;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class MilestoneResponseToDomainMapper
{
    private IssueResponseToDomainMapper $issueResponseToDomainMapper;

    public function __construct(IssueResponseToDomainMapper $issueResponseToDomainMapper)
    {
        $this->issueResponseToDomainMapper = $issueResponseToDomainMapper;
    }

    public function map(MilestoneResponse $milestoneResponse, IssueResponse ...$issueResponses): Milestone
    {
        return new Milestone(
            $milestoneResponse->getTitle(),
            $milestoneResponse->getUrl(),
            array_map(
                fn (IssueResponse $issueResponse): Issue => $this->issueResponseToDomainMapper->map($issueResponse),
                $issueResponses,
            ),
            new Progress(
                $milestoneResponse->getClosedIssues(),
                $milestoneResponse->getOpenIssues(),
            ),
        );
    }
}
