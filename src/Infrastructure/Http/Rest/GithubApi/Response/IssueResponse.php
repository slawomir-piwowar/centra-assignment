<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response;

class IssueResponse
{
    private const STATE_CLOSED = 'closed';

    private int $id;
    private int $number;
    private string $title;
    private string $state;
    private string $url;
    /** @var array<string>  */
    private array $labels;
    private bool $isPullRequest;
    private ?string $assignee;
    private ?string $body;
    private ?string $closedAt;

    public function __construct(
        int $id,
        int $number,
        string $title,
        string $state,
        string $url,
        array $labels,
        bool $isPullRequest,
        ?string $assignee,
        ?string $body,
        ?string $closedAt
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->body = $body;
        $this->title = $title;
        $this->state = $state;
        $this->number = $number;
        $this->labels = $labels;
        $this->assignee = $assignee;
        $this->closedAt = $closedAt;
        $this->isPullRequest = $isPullRequest;
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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function hasAssignee(): bool
    {
        return null !== $this->assignee;
    }

    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    public function getClosedAt(): ?string
    {
        return $this->closedAt;
    }

    public function isClosed(): bool
    {
        return self::STATE_CLOSED === $this->state;
    }

    public function isPullRequest(): bool
    {
        return $this->isPullRequest;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }
}
