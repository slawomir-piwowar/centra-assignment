<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use DateTime;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\IssueState;
use KanbanBoard\Domain\Progress;
use PHPUnit\Framework\TestCase;

class IssueTest extends TestCase
{
    private string $title;
    private string $url;
    private bool $isPaused;
    private bool $isPullRequest;
    private Progress $progress;
    private string $assignee;
    private DateTime $closedAt;

    public function testInitializationIsWorkingCorrectly(): void
    {
        $issue = $this->getIssueWithState($this->createMock(IssueState::class));

        $this->assertEquals($this->title, $issue->getTitle());
        $this->assertEquals($this->url, $issue->getUrl());
        $this->assertEquals($this->isPaused, $issue->isPaused());
        $this->assertEquals($this->isPullRequest, $issue->isPullRequest());
        $this->assertSame($this->progress, $issue->getProgress());
        $this->assertEquals($this->assignee, $issue->getAssignee());
        $this->assertSame($this->closedAt, $issue->getClosedAt());
    }

    public function testIssueIsCompleted(): void
    {
        $issue = $this->getIssueWithState(IssueState::COMPLETED());

        $this->assertTrue($issue->isCompleted());
        $this->assertFalse($issue->isActive());
        $this->assertFalse($issue->isQueued());
    }

    public function testIssueIsActive(): void
    {
        $issue = $this->getIssueWithState(IssueState::ACTIVE());

        $this->assertFalse($issue->isCompleted());
        $this->assertTrue($issue->isActive());
        $this->assertFalse($issue->isQueued());
    }

    public function testIssueIsQueued(): void
    {
        $issue = $this->getIssueWithState(IssueState::QUEUED());

        $this->assertFalse($issue->isCompleted());
        $this->assertFalse($issue->isActive());
        $this->assertTrue($issue->isQueued());
    }

    protected function getIssueWithState(IssueState $issueState): Issue
    {
        return new Issue(
            $this->title,
            $this->url,
            $this->isPaused,
            $this->isPullRequest,
            $issueState,
            $this->progress,
            $this->assignee,
            $this->closedAt,
        );
    }

    protected function setUp(): void
    {
        $this->title = 'title';
        $this->url = 'url';
        $this->isPaused = true;
        $this->isPullRequest = false;
        $this->progress = $this->createMock(Progress::class);
        $this->assignee = 'assignee';
        $this->closedAt = new DateTime();
    }
}
