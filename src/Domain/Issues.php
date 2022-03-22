<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

use Countable;
use InvalidArgumentException;

class Issues implements Countable
{
    private array $issues;

    public function __construct(Issue ...$issues)
    {
        if (empty($issues)) {
            throw new InvalidArgumentException('Issues cannot be empty');
        }

        $this->issues = $issues;
    }

    public function count(): int
    {
        return count($this->issues);
    }
}
