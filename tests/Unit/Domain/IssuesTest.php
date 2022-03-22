<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use InvalidArgumentException;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Issues;
use PHPUnit\Framework\TestCase;

class IssuesTest extends TestCase
{
    private const ISSUES_AMOUNT = 100;

    public function testInitializationIsThrowingErrorOnEmptyIssues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Issues();
    }

    public function testCountIsReturningCorrectAmount(): void
    {
        $issues = new Issues(
            ...array_fill(0, self::ISSUES_AMOUNT, $this->createMock(Issue::class))
        );

        $this->assertEquals(self::ISSUES_AMOUNT, $issues->count());
        $this->assertEquals(self::ISSUES_AMOUNT, count($issues));
    }
}
