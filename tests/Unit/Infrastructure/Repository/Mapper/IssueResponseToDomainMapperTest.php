<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repository\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IssueResponseToDomainMapperTest extends TestCase
{
    /**
     * @var MockObject|IssueResponse
     */
    private MockObject $issueResponse;

    public function testStateIsCompletedWhenIssueIsClosed(): void
    {
    }

    public function testStateIsActiveWhenIssueHasAssignee(): void
    {

    }

    public function testStateIsQueued(): void
    {

    }

    protected function setUp(): void
    {
        $this->issueResponse = $this->createMock(IssueResponse::class);
    }
}
