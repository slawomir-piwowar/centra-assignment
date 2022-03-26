<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Http\Rest\GithubApi\V3\Mapper;

use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\IssueResponseMapper;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\IssueResponseMapper
 */
class IssueResponseMapperTest extends TestCase
{
    private IssueResponseMapper $mapper;

    public function testBasicDataAreMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'title' => 'test_title',
            'html_url' => 'test_url',
            'body' => null,
            'closed_at' => null,
        ]));

        $this->assertEquals('test_title', $mapped->getTitle());
        $this->assertEquals('test_url', $mapped->getUrl());
        $this->assertNull($mapped->getBody());
        $this->assertFalse($mapped->hasAssignee());
        $this->assertNull($mapped->getAssignee());
        $this->assertEmpty($mapped->getLabels());
        $this->assertFalse($mapped->isPullRequest());
        $this->assertFalse($mapped->isClosed());
        $this->assertNull($mapped->getClosedAt());
    }

    public function testBodyIsMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'body' => 'test_body',
        ]));

        $this->assertEquals('test_body', $mapped->getBody());
    }

    public function testAssigneeIsMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'assignee' => [
                'avatar_url' => 'test_assignee',
            ]
        ]));

        $this->assertTrue($mapped->hasAssignee());
        $this->assertEquals('test_assignee', $mapped->getAssignee());
    }

    public function testLabelsAreMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'labels' => [
                ['name' => 'label_1'],
                ['name' => 'label_2'],
                ['name' => 'label_3'],
            ]
        ]));

        $this->assertNotEmpty($mapped->getLabels());
        $this->assertCount(3, $mapped->getLabels());
        $this->assertEquals('label_1', $mapped->getLabels()[0]);
        $this->assertEquals('label_2', $mapped->getLabels()[1]);
        $this->assertEquals('label_3', $mapped->getLabels()[2]);
    }

    public function testPullRequestIsMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'pull_request' => [
                'test' => 'test',
            ]
        ]));

        $this->assertTrue($mapped->isPullRequest());
    }

    public function testClosedAtIsMappedCorrectly(): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'closed_at' => 'test_closed_at',
        ]));

        $this->assertEquals('test_closed_at', $mapped->getClosedAt());
    }

    public function isClosedDataProvider(): array
    {
        return [
            [true, 'closed'],
            [false, ' closed'],
            [false, 'closed '],
            [false, 'c losed'],
            [false, 'clo sed'],
            [false, 'Closed'],
            [false, 'CLOSED'],
            [false, 'another_state'],
            [false, 'cLoSeD'],
        ];
    }

    /**
     * @dataProvider isClosedDataProvider
     */
    public function testIsClosedIsMappedCorrectly(bool $expectedResult, string $state): void
    {
        $mapped = $this->mapper->map($this->getPayload([
            'state' => $state,
        ]));

        $this->assertEquals($expectedResult, $mapped->isClosed());
    }

    protected function getPayload(array $override = []): array
    {
        return array_merge([
            'title' => 'title',
            'state' => 'state',
            'html_url' => 'html_url',
            'body' => 'body',
            'closed_at' => 'closed_at',
        ], $override);
    }

    protected function setUp(): void
    {
        $this->mapper = new IssueResponseMapper();
    }
}
