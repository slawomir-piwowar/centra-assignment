<?php
declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Http\Rest\GithubApi\V3;

use Github\Client;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\GithubApi;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\IssueResponseMapper;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\MilestoneResponseMapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubApiTest extends TestCase
{
    /**
     * @var Client|MockObject
     */
    private Client $client;

    /**
     * @var MilestoneResponseMapper|MockObject
     */
    private $milestoneResponseMapper;

    /**
     * @var IssueResponseMapper|MockObject
     */
    private $issueResponseMapper;

    private GithubApi $githubApi;

    public function testGetMilestones(): void
    {
        $this->issueResponseMapper->expects($this->never())
            ->method($this->anything());

        $this->milestoneResponseMapper->expects($this->once())
            ->method('map');

        $this->githubApi->expects($this->once())
            ->method('fetchMilestones')
            ->willReturn([[]]);

        $this->githubApi->expects($this->never())
            ->method('fetchIssues');

        $this->githubApi->getMilestones('token', 'repository');
    }

    public function testGetIssues(): void
    {
        $this->milestoneResponseMapper->expects($this->never())
            ->method($this->anything());

        $this->issueResponseMapper->expects($this->once())
            ->method('map');

        $this->githubApi->expects($this->once())
            ->method('fetchIssues')
            ->willReturn([[]]);

        $this->githubApi->expects($this->never())
            ->method('fetchMilestones');

        $this->githubApi->getIssues('token', 'repository', 1);
    }

    protected function setUp(): void
    {
        $this->milestoneResponseMapper = $this->createMock(MilestoneResponseMapper::class);

        $this->issueResponseMapper = $this->createMock(IssueResponseMapper::class);

        $this->client = $this->createMock(Client::class);

        $this->client->expects($this->once())
            ->method('authenticate')
            ->with(
                $this->identicalTo('token'),
                $this->identicalTo('access_token_header'),
            );

        $this->githubApi = $this->getMockBuilder(GithubApi::class)
            ->setConstructorArgs([
                'account',
                $this->client,
                $this->milestoneResponseMapper,
                $this->issueResponseMapper,
            ])
            ->onlyMethods(['fetchMilestones', 'fetchIssues'])
            ->getMock();
    }
}
