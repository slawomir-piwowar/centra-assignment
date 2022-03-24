<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;

interface GithubApiInterface
{
    /**
     * @return MilestoneResponse[]
     */
    public function getMilestones(string $repository): array;

    /**
     * @return IssueResponse[]
     */
    public function getIssues(string $repository, int $number): array;
}
