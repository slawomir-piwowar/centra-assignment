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
            $this->getProgress($issueResponse),
            $issueResponse->getAssignee(),
            $issueResponse->getBody(),
            $this->getClosedAt($issueResponse),
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

    protected function getProgress(IssueResponse $issueResponse): Progress
    {
        return new Progress(
            mb_substr_count(mb_strtolower($issueResponse->getBody() ?? ''), '[x]'),
            mb_substr_count(mb_strtolower($issueResponse->getBody() ?? ''), '[ ]'),
        );
    }

    protected function getClosedAt(IssueResponse $issueResponse): ?DateTimeInterface
    {
        return $issueResponse->getClosedAt()
            ? new DateTime($issueResponse->getClosedAt())
            : null;
    }
}
