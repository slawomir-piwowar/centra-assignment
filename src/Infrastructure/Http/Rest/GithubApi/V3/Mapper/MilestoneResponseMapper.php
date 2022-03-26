<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;
use Nette\Utils\Arrays;

class MilestoneResponseMapper
{
    public function map(array $data): MilestoneResponse
    {
        return new MilestoneResponse(
            Arrays::get($data, 'number'),
            Arrays::get($data, 'title'),
            Arrays::get($data, 'html_url'),
            Arrays::get($data, 'open_issues'),
            Arrays::get($data, 'closed_issues'),
        );
    }
}
