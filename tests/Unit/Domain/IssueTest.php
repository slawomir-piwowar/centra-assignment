<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use DateTime;
use KanbanBoard\Domain\Issue;
use KanbanBoard\Domain\Progress;
use PHPUnit\Framework\TestCase;

class IssueTest extends TestCase
{
    public function testInitializationIsWorkingCorrectly(): void
    {
        $id = 1;
        $number = 2;
        $title = 'title';
        $url = 'url';
        $assignee = 'assignee';
        $isPaused = true;
        $progress = $this->createMock(Progress::class);
        $body = 'body';
        $closedAt = new DateTime();

        $issue = new Issue($id, $number, $title, $url, $assignee, $isPaused, $progress, $body, $closedAt);

        $this->assertEquals($id, $issue->getId());
        $this->assertEquals($number, $issue->getNumber());
        $this->assertEquals($title, $issue->getTitle());
        $this->assertEquals($url, $issue->getUrl());
        $this->assertEquals($assignee, $issue->getAssignee());
        $this->assertEquals($isPaused, $issue->isPaused());
        $this->assertSame($progress, $issue->getProgress());
        $this->assertEquals($body, $issue->getBody());
        $this->assertSame($closedAt, $issue->getClosedAt());
    }
}
