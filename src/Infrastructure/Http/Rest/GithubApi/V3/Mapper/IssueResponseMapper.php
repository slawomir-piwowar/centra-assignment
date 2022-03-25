<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use Nette\Utils\Arrays;

class IssueResponseMapper
{
    public function map(array $data): IssueResponse
    {
        return new IssueResponse(
            Arrays::get($data, 'id'),
            Arrays::get($data, 'number'),
            Arrays::get($data, 'title'),
            Arrays::get($data, 'state'),
            Arrays::get($data, 'url'),
            array_column(Arrays::get($data, 'labels', []), 'name'),
            Arrays::get($data, ['assignee', 'avatar_url'], null),
            Arrays::get($data, 'body'),
            Arrays::get($data, 'closed_at'),
        );
    }
}