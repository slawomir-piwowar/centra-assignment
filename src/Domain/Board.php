<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

class Board
{
    /**
     * @var array<Milestone>
     */
    private array $milestones;

    public function __construct(Milestone ...$milestones)
    {
        $this->milestones = $milestones;
    }

    /** @return array<Milestone> */
    public function getMilestones(): array
    {
        return $this->milestones;
    }
}
