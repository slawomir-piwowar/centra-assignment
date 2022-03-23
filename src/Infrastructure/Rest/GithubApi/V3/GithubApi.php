<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Rest\GithubApi\V3;

use KanbanBoard\Infrastructure\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Rest\GithubApi\Response\MilestoneResponse;

class GithubApi implements GithubApiInterface
{
    public function getMilestone(): MilestoneResponse
    {

    }

    public function getIssue(): IssueResponse
    {

    }
}
