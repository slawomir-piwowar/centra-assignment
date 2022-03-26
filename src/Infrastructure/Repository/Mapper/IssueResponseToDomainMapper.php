<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Repository\Mapper;

use DateTime;
use DateTimeInterface;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\IssueState;
use KanbanBoard\Domain\Progress;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;

class IssueResponseToDomainMapper
{
    private array $pausedLabels;

    public function __construct(array $pausedLabels)
    {
        $this->pausedLabels = $pausedLabels;
    }

    public function map(IssueResponse $issueResponse): Issue
    {
        return new Issue(
            $issueResponse->getTitle(),
            $issueResponse->getUrl(),
            $this->pausedLabels($issueResponse->getLabels(), $this->pausedLabels),
            $issueResponse->isPullRequest(),
            $this->getState($issueResponse),
            $this->getProgress($issueResponse->getBody()),
            $issueResponse->getAssignee(),
            $this->getClosedAt($issueResponse->getClosedAt()),
        );
    }

    protected function pausedLabels(array $currentLabels, array $pausedLabels): int
    {
        return count(array_intersect($currentLabels, $pausedLabels));
    }

    protected function getState(IssueResponse $issueResponse): IssueState
    {
        if ($issueResponse->isClosed()) {
            return IssueState::COMPLETED();
        }

        if ($issueResponse->hasAssignee()) {
            return IssueState::ACTIVE();
        }

        return IssueState::QUEUED();
    }

    protected function getProgress(?string $body): Progress
    {
        return new Progress(
            mb_substr_count(mb_strtolower($body ?? ''), '[x]'),
            mb_substr_count(mb_strtolower($body ?? ''), '[ ]'),
        );
    }

    protected function getClosedAt(?string $closedAt): ?DateTimeInterface
    {
        return $closedAt ? new DateTime($closedAt) : null;
    }
}
