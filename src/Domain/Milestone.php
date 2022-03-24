<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

class Milestone
{
    private int $number;
    private string $title;
    private Progress $progress;

    /**
     * @var array|Issue[]
     */
    private array $issues;

    public function __construct(
        int $number,
        string $title,
        array $issues,
        Progress $progress
    ) {
        $this->title = $title;
        $this->number = $number;
        $this->progress = $progress;
        $this->issues = array_map(static fn (Issue $issue): Issue => $issue, $issues);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }

    public function queued(): array
    {
        return array_filter($this->issues, fn (Issue $issue): bool => $issue->isQueued());
    }

    public function active(): array
    {
        return array_filter($this->issues, fn (Issue $issue): bool => $issue->isActive());
    }

    public function completed(): array
    {
        return array_filter($this->issues, fn (Issue $issue): bool => $issue->isCompleted());
    }
}
