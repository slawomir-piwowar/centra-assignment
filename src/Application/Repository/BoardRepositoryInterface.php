<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Repository;

use KanbanBoard\Domain\Board;

interface BoardRepositoryInterface
{
    public function getByRepository(string $repository): Board;
}
