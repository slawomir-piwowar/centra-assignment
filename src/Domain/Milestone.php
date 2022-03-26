<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

class Milestone
{
    private string $title;
    private string $url;
    private Progress $progress;
    /** @var array<Issue>  */
    private array $issues;

    public function __construct(
        string $title,
        string $url,
        array $issues,
        Progress $progress
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->progress = $progress;
        $this->issues = array_map(static fn (Issue $issue): Issue => $issue, $issues);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }

    /**
     * @return array<Issue>
     */
    public function queued(): array
    {
        return array_values(array_filter(
            $this->issues,
            fn (Issue $issue): bool => $issue->isQueued() && !$issue->isPullRequest(),
        ));
    }

    /**
     * @return array<Issue>
     */
    public function active(): array
    {
        return array_values(array_filter(
            $this->issues,
            fn (Issue $issue): bool => $issue->isActive() && !$issue->isPullRequest(),
        ));
    }

    /**
     * @return array<Issue>
     */
    public function completed(): array
    {
        return array_values(array_filter(
            $this->issues,
            fn (Issue $issue): bool => $issue->isCompleted() && !$issue->isPullRequest(),
        ));
    }
}
