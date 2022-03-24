<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response;

class MilestoneResponse
{
    private int $number;
    private string $title;
    private int $openIssues;
    private int $closedIssues;

    public function __construct(
        int $number,
        string $title,
        int $openIssues,
        int $closedIssues
    ) {
        $this->number = $number;
        $this->title = $title;
        $this->openIssues = $openIssues;
        $this->closedIssues = $closedIssues;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOpenIssues(): int
    {
        return $this->openIssues;
    }

    public function getClosedIssues(): int
    {
        return $this->closedIssues;
    }
}
