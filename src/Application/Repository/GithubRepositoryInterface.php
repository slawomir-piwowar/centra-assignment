<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Repository;

use KanbanBoard\Domain\Issues;
use KanbanBoard\Domain\Milestone;

interface GithubRepositoryInterface
{
    public function getMilestone(): Milestone;

    public function getIssues(): Issues;
}
