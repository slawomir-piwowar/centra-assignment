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
    private string $assignee;
    private bool $isPaused;
    private Progress $progress;
    private ?string $body;
    private ?DateTimeInterface $closedAt;

    public function __construct(
        int $id,
        int $number,
        string $title,
        string $url,
        string $assignee,
        bool $isPaused,
        Progress $progress,
        ?string $body,
        ?DateTimeInterface $closedAt
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
        $this->assignee = $assignee;
        $this->isPaused = $isPaused;
        $this->progress = $progress;
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

    public function getAssignee(): string
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getClosedAt(): ?DateTimeInterface
    {
        return $this->closedAt;
    }
}
