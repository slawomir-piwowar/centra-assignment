<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\IssueState;
use KanbanBoard\Domain\Milestone;
use KanbanBoard\Domain\Progress;
use PHPUnit\Framework\TestCase;

/** @coversDefaultClass \KanbanBoard\Domain\Milestone */
class MilestoneTest extends TestCase
{
    public function testInitializationWithoutIssues(): void
    {
        $progress = $this->createMock(Progress::class);

        $milestone = new Milestone('title', 'url', [], $progress);

        $this->assertEquals('title', $milestone->getTitle());
        $this->assertEquals('url', $milestone->getUrl());
        $this->assertSame($progress, $milestone->getProgress());
        $this->assertEmpty($milestone->queued());
        $this->assertEmpty($milestone->active());
        $this->assertEmpty($milestone->completed());
    }

    public function testQueuedIssuesAreReturningCorrectly(): Milestone
    {
        $milestone = new Milestone(
            'title',
            'url',
            [
                $this->createIssue(IssueState::QUEUED(), true),
                $this->createIssue(IssueState::QUEUED(), false),
                $this->createIssue(IssueState::ACTIVE(), true),
                $this->createIssue(IssueState::ACTIVE(), false),
                $this->createIssue(IssueState::ACTIVE(), true),
                $this->createIssue(IssueState::ACTIVE(), false),
                $this->createIssue(IssueState::COMPLETED(), true),
                $this->createIssue(IssueState::COMPLETED(), false),
                $this->createIssue(IssueState::COMPLETED(), true),
                $this->createIssue(IssueState::COMPLETED(), false),
                $this->createIssue(IssueState::COMPLETED(), true),
                $this->createIssue(IssueState::COMPLETED(), false),
                $this->createIssue(IssueState::COMPLETED(), true),
                $this->createIssue(IssueState::COMPLETED(), false),
            ],
            $this->createMock(Progress::class),
        );

        $this->assertCount(1, $milestone->queued());
        $this->assertContainsOnlyInstancesOf(Issue::class, $milestone->queued());

        return $milestone;
    }

    /** @depends testQueuedIssuesAreReturningCorrectly */
    public function testActiveIssuesAreReturningCorrectly(Milestone $milestone): Milestone
    {
        $this->assertCount(2, $milestone->active());
        $this->assertContainsOnlyInstancesOf(Issue::class, $milestone->active());

        return $milestone;
    }

    /** @depends testActiveIssuesAreReturningCorrectly */
    public function testCompletedIssuesAreReturningCorrectly(Milestone $milestone): void
    {
        $this->assertCount(4, $milestone->completed());
        $this->assertContainsOnlyInstancesOf(Issue::class, $milestone->completed());
    }

    protected function createIssue(IssueState $issueState, bool $isPullRequest): Issue
    {
        return new Issue(
            'test_title',
            'test_url',
            0,
            $isPullRequest,
            $issueState,
            $this->createMock(Progress::class),
            null,
            null,
        );
    }
}
