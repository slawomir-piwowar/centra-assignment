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
            $issueResponse->getId(),
            $issueResponse->getNumber(),
            $issueResponse->getTitle(),
            $issueResponse->getUrl(),
            $this->isPaused($issueResponse->getLabels(), $this->pausedLabels),
            $issueResponse->isPullRequest(),
            $this->getState($issueResponse),
            $this->getProgress($issueResponse->getBody()),
            $issueResponse->getAssignee(),
            $this->getClosedAt($issueResponse->getClosedAt()),
        );
    }

    protected function isPaused(array $currentLabels, array $pausedLabels): bool
    {
        return !!array_intersect($currentLabels, $pausedLabels);
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
