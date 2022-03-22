<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

class Milestone
{
    private int $number;
    private string $title;
    private string $repository;
    private Issues $issues;
    private Progress $progress;

    public function __construct(int $number, string $title, string $repository, Issues $issues, Progress $progress)
    {
        $this->title = $title;
        $this->repository = $repository;
        $this->number = $number;
        $this->issues = $issues;
        $this->progress = $progress;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getRepository(): string
    {
        return $this->repository;
    }

    public function getIssues(): Issues
    {
        return $this->issues;
    }

    public function getProgress(): Progress
    {
        return $this->progress;
    }
}
