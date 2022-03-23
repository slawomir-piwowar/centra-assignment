<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Repository;

use KanbanBoard\Application\Repository\GithubRepositoryInterface;
use KanbanBoard\Domain\Issues;
use KanbanBoard\Domain\Milestone;

class GithubRepository implements GithubRepositoryInterface
{
    public function getMilestone(): Milestone
    {

    }

    public function getIssues(): Issues
    {

    }
}
