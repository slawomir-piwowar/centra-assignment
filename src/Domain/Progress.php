<?php
declare(strict_types=1);

namespace KanbanBoard\Domain;

use InvalidArgumentException;

class Progress
{
    private int $percent = 0;

    public function __construct(int $completed, int $remaining)
    {
        if (0 > $completed || 0 > $remaining) {
            throw new InvalidArgumentException('Progress initial values has to be greater than 0');
        }

        $total = $completed + $remaining;

        if ($total > 0) {
            $this->percent = (int)round($completed / ($completed + $remaining) * 100);
        }
    }

    public function getPercent(): int
    {
        return $this->percent;
    }
}
