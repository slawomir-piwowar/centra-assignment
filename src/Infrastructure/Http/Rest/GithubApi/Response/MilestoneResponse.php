<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response;

class MilestoneResponse
{
    private int $number;
    private string $title;
    private string $url;
    private int $openIssues;
    private int $closedIssues;

    public function __construct(int $number, string $title, string $url, int $openIssues, int $closedIssues)
    {
        $this->number = $number;
        $this->title = $title;
        $this->openIssues = $openIssues;
        $this->closedIssues = $closedIssues;
        $this->url = $url;
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

    public function getOpenIssues(): int
    {
        return $this->openIssues;
    }

    public function getClosedIssues(): int
    {
        return $this->closedIssues;
    }
}
