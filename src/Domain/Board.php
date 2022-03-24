<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

use InvalidArgumentException;

class Board
{
    /**
     * @var array|Milestone[]
     */
    private array $milestones;

    public function __construct(Milestone ...$milestones)
    {
        if (empty($milestones)) {
            throw new InvalidArgumentException('Milestones cannot be empty');
        }

        $this->milestones = $milestones;
    }

    public function getMilestones(): array
    {
        return $this->milestones;
    }
}
