<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use KanbanBoard\Domain\IssueState;
use PHPUnit\Framework\TestCase;

class IssueStateTest extends TestCase
{
    public function testStateCompletedIsWorkingCorrectly(): void
    {
        $state = IssueState::COMPLETED();

        $this->assertEquals('completed', $state->toString());
        $this->assertTrue($state->isEqual(IssueState::COMPLETED()));
        $this->assertFalse($state->isEqual(IssueState::ACTIVE()));
        $this->assertFalse($state->isEqual(IssueState::QUEUED()));
    }

    public function testStateActiveIsWorkingCorrectly(): void
    {
        $state = IssueState::ACTIVE();

        $this->assertEquals('active', $state->toString());
        $this->assertFalse($state->isEqual(IssueState::COMPLETED()));
        $this->assertTrue($state->isEqual(IssueState::ACTIVE()));
        $this->assertFalse($state->isEqual(IssueState::QUEUED()));
    }

    public function testStateQueuedIsWorkingCorrectly(): void
    {
        $state = IssueState::QUEUED();

        $this->assertEquals('queued', $state->toString());
        $this->assertFalse($state->isEqual(IssueState::COMPLETED()));
        $this->assertFalse($state->isEqual(IssueState::ACTIVE()));
        $this->assertTrue($state->isEqual(IssueState::QUEUED()));
    }
}
