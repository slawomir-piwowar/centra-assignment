<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

use DateTimeInterface;

class Issue
{
    private string $title;
    private string $url;
    private bool $isPaused;
    private bool $isPullRequest;
    private IssueState $issueState;
    private Progress $progress;
    private ?string $assignee;
    private ?DateTimeInterface $closedAt;

    public function __construct(
        string $title,
        string $url,
        bool $isPaused,
        bool $isPullRequest,
        IssueState $issueState,
        Progress $progress,
        ?string $assignee,
        ?DateTimeInterface $closedAt
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->isPaused = $isPaused;
        $this->issueState = $issueState;
        $this->progress = $progress;
        $this->assignee = $assignee;
        $this->closedAt = $closedAt;
        $this->isPullRequest = $isPullRequest;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function isPaused(): bool
    {
        return $this->isPaused;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }

    public function getClosedAt(): ?DateTimeInterface
    {
        return $this->closedAt;
    }

    public function isCompleted(): bool
    {
        return $this->issueState->isEqual(IssueState::COMPLETED());
    }

    public function isActive(): bool
    {
        return $this->issueState->isEqual(IssueState::ACTIVE());
    }

    public function isQueued(): bool
    {
        return $this->issueState->isEqual(IssueState::QUEUED());
    }

    public function isPullRequest(): bool
    {
        return $this->isPullRequest;
    }
}
