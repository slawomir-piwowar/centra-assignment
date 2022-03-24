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
    public function map(IssueResponse $issueResponse): Issue
    {
        return new Issue(
            $issueResponse->getId(),
            $issueResponse->getNumber(),
            $issueResponse->getTitle(),
            $issueResponse->getUrl(),
            $issueResponse->hasLabelWaitingForFeedback(),
            $this->getState($issueResponse),
            $this->getProgress($issueResponse),
            $issueResponse->getAssignee(),
            $issueResponse->getBody(),
            $this->getClosedAt($issueResponse),
        );
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
