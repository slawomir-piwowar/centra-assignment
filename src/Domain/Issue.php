<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

use DateTimeInterface;

class Issue
{
    private int $id;
    private int $number;
    private string $title;
    private string $url;
    private bool $isPaused;
    private IssueState $issueState;
    private Progress $progress;
    private ?string $assignee;
    private ?string $body;
    private ?DateTimeInterface $closedAt;

    public function __construct(
        int $id,
        int $number,
        string $title,
        string $url,
        bool $isPaused,
        IssueState $issueState,
        Progress $progress,
        ?string $assignee,
        ?string $body,
        ?DateTimeInterface $closedAt
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
        $this->url = $url;
        $this->isPaused = $isPaused;
        $this->issueState = $issueState;
        $this->progress = $progress;
        $this->assignee = $assignee;
        $this->body = $body;
        $this->closedAt = $closedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
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

    public function getIssueState(): IssueState
    {
        return $this->issueState;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }

    public function getBody(): ?string
    {
        return $this->body;
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
}
