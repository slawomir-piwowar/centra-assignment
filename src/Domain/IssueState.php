<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

class IssueState
{
    private const COMPLETED = 'completed';
    private const ACTIVE = 'active';
    private const QUEUED = 'queued';

    private string $state;

    public static function COMPLETED(): self
    {
        return new self(self::COMPLETED);
    }

    public static function ACTIVE(): self
    {
        return new self(self::ACTIVE);
    }

    public static function QUEUED(): self
    {
        return new self(self::QUEUED);
    }

    private function __construct(string $state)
    {
        $this->state = $state;
    }

    public function toString(): string
    {
        return $this->state;
    }

    public function isEqual(self $issueState): bool
    {
        return $this->state === $issueState->toString();
    }
}
