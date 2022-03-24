<?php
declare(strict_types=1);

namespace KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3;

use Github\AuthMethod;
use Github\Client;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\GithubApiInterface;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\IssueResponse;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\Response\MilestoneResponse;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\IssueResponseMapper;
use KanbanBoard\Infrastructure\Http\Rest\GithubApi\V3\Mapper\MilestoneResponseMapper;

class GithubApi implements GithubApiInterface
{
    private Client $client;
    private MilestoneResponseMapper $milestoneResponseMapper;
    private IssueResponseMapper $issueResponseMapper;

    public function __construct(
        Client $client,
        MilestoneResponseMapper $milestoneResponseMapper,
        IssueResponseMapper $issueResponseMapper
    ) {
        $this->client = $client;
        // TODO
        $this->client->authenticate('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', AuthMethod::ACCESS_TOKEN);
        $this->milestoneResponseMapper = $milestoneResponseMapper;
        $this->issueResponseMapper = $issueResponseMapper;
    }

    /**
     * @return MilestoneResponse[]
     */
    public function getMilestones(string $repository): array
    {
        return array_map(
            fn (array $data): MilestoneResponse => $this->milestoneResponseMapper->map($data),
            $this->client->api('issues')->milestones()->all('slawomir-piwowar', $repository),
        );
    }

    /**
     * @return IssueResponse[]
     */
    public function getIssues(string $repository, int $number): array
    {
        return array_map(
            fn (array $data): IssueResponse => $this->issueResponseMapper->map($data),
            $this->client->api('issue')->all('slawomir-piwowar', $repository, [
                'milestone' => $number,
                'state' => 'all',
            ]),
        );
    }
}
