<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use Nette\Utils\Arrays;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class IssueResponseMapper
{
    // @codingStandardsIgnoreLine
    public function map(array $data): IssueResponse
    {
        return new IssueResponse(
            Arrays::get($data, 'title'),
            Arrays::get($data, 'state'),
            Arrays::get($data, 'html_url'),
            array_column(Arrays::get($data, 'labels', []), 'name'),
            array_key_exists('pull_request', $data),
            Arrays::get($data, ['assignee', 'avatar_url'], null),
            Arrays::get($data, 'body'),
            Arrays::get($data, 'closed_at'),
        );
    }
}
