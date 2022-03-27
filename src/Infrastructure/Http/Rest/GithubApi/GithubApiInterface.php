<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;

interface GithubApiInterface
{
    /** @return array<MilestoneResponse> */
    public function getMilestones(string $token, string $repository): array;

    /** @return array<IssueResponse> */
    public function getIssues(string $token, string $repository, int $number): array;
}
