<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use KanbanBoard\Domain\Board;
use KanbanBoard\Domain\Milestone;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testInitializationWithoutMilestonesIsPossible(): void
    {
        $board = new Board();

        $this->assertEmpty($board->getMilestones());
    }

    public function testInitializationWithSingleMilestoneIsWorkingCorrectly(): void
    {
        $board = new Board($this->createMock(Milestone::class));

        $this->assertNotEmpty($board->getMilestones());
        $this->assertCount(1, $board->getMilestones());
    }

    public function testInitializationWithMultipleMilestonesIsWorkingCorrectly(): void
    {
        $board = new Board(
            $this->createMock(Milestone::class),
            $this->createMock(Milestone::class),
            $this->createMock(Milestone::class),
            $this->createMock(Milestone::class),
            $this->createMock(Milestone::class),
        );

        $this->assertNotEmpty($board->getMilestones());
        $this->assertCount(5, $board->getMilestones());
    }
}
