<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Http\Rest\GithubApi\V3\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\MilestoneResponseMapper;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\MilestoneResponseMapper
 */
class MilestoneResponseMapperTest extends TestCase
{
    private MilestoneResponseMapper $mapper;

    public function testMapperIsWorkingCorrectly(): void
    {
        $mapped = $this->mapper->map([
            'number' => 1,
            'title' => 'title',
            'html_url' => 'url',
            'open_issues' => 2,
            'closed_issues' => 3,
        ]);

        $this->assertEquals(1, $mapped->getNumber());
        $this->assertEquals('title', $mapped->getTitle());
        $this->assertEquals('url', $mapped->getUrl());
        $this->assertEquals(2, $mapped->getOpenIssues());
        $this->assertEquals(3, $mapped->getClosedIssues());
    }

    protected function setUp(): void
    {
        $this->mapper = new MilestoneResponseMapper();
    }
}
