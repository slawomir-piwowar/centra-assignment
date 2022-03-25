<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repository\Mapper;

use DateTimeInterface;
use KanbanBoard\Domain\IssueState;
use KanbanBoard\Domain\Progress;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Repository\Mapper\IssueResponseToDomainMapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IssueResponseToDomainMapperTest extends TestCase
{
    /**
     * @var MockObject|IssueResponse
     */
    private MockObject $issueResponse;
    private IssueResponseToDomainMapper $mapper;

    public function isPausedDataProvider(): array
    {
        return [
            'empty both arrays' => [false, [], []],
            'empty paused labels' => [false, ['test'], []],
            'empty current labels' => [false, [], ['test']],
            'different labels' => [false, ['test1'], ['test2']],
            'different multiple labels' => [false, ['test1', 'test2', 'test3'], ['test4', 'test5', 'test6']],
            'same single labels' => [true, ['test1'], ['test1']],
            'one match' => [true, ['test1', 'test5', 'test3'], ['test4', 'test5', 'test6']],
            'two matches' => [true, ['test1', 'test5', 'test6'], ['test4', 'test5', 'test6']],
            'all matches' => [true, ['test4', 'test5', 'test6'], ['test4', 'test5', 'test6']],
        ];
    }

    /**
     * @dataProvider isPausedDataProvider
     */
    public function testIsPaused(bool $expectedResult, array $currentLabels, array $pausedLabels): void
    {
        $this->assertEquals($expectedResult, $this->mapper->isPaused($currentLabels, $pausedLabels));
    }

    public function progressDataProvider(): array
    {
        return [
            [0, null],
            [0, ''],
            [100, '[x]'],
            [0, '[ ]'],
            [50, '[x][ ]'],
            [100, '[x][x][x][x][x]'],
            [80, '[x][x][x][x][ ]'],
            [60, '[x][x][x][ ][ ]'],
            [40, '[x][x][ ][ ][ ]'],
            [20, '[x][ ][ ][ ][ ]'],
            [0, '[ ][ ][ ][ ][ ]'],
        ];
    }

    /**
     * @dataProvider progressDataProvider
     */
    public function testGetProgressIsWorkingCorrectly(int $expectedPercent, ?string $body): void
    {
        $this->assertEquals($expectedPercent, $this->mapper->getProgress($body)->getPercent());
    }

    public function testClosedAtIsNullIfNullIsGiven(): void
    {
        $this->assertNull($this->mapper->getClosedAt(null));
    }

    public function testClosedAtIsMappedToDatetimeIfNotNullGiven(): void
    {
        $closedAt = $this->mapper->getClosedAt('2000-01-01 01:01:01');

        $this->assertNotNull($closedAt);
        $this->assertInstanceOf(DateTimeInterface::class, $closedAt);
        $this->assertEquals('2000-01-01 01:01:01', $closedAt->format('Y-m-d H:i:s'));
    }

    public function testStateIsCompletedWhenIssueIsClosed(): void
    {
        $this->issueResponse->expects($this->once())
            ->method('isClosed')
            ->willReturn(true);

        $this->assertEquals('completed', $this->mapper->getState($this->issueResponse)->toString());
    }

    public function testStateIsActiveWhenIssueHasAssignee(): void
    {
        $this->issueResponse->expects($this->once())
            ->method('isClosed')
            ->willReturn(false);

        $this->issueResponse->expects($this->once())
            ->method('hasAssignee')
            ->willReturn(true);

        $this->assertEquals('active', $this->mapper->getState($this->issueResponse)->toString());
    }

    public function testStateIsQueued(): void
    {
        $this->issueResponse->expects($this->once())
            ->method('isClosed')
            ->willReturn(false);

        $this->issueResponse->expects($this->once())
            ->method('hasAssignee')
            ->willReturn(false);

        $this->assertEquals('queued', $this->mapper->getState($this->issueResponse)->toString());
    }

    protected function setUp(): void
    {
        $this->issueResponse = $this->createMock(IssueResponse::class);

        $this->mapper = new class([]) extends IssueResponseToDomainMapper
        {
            public function getProgress(?string $body): Progress
            {
                return parent::getProgress($body);
            }

            public function isPaused(array $currentLabels, array $pausedLabels): bool
            {
                return parent::isPaused($currentLabels, $pausedLabels);
            }

            public function getState(IssueResponse $issueResponse): IssueState
            {
                return parent::getState($issueResponse);
            }

            public function getClosedAt(?string $closedAt): ?DateTimeInterface
            {
                return parent::getClosedAt($closedAt);
            }
        };
    }
}
