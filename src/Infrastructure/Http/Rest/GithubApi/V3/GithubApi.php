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
    private string $account;

    public function __construct(
        string $account,
        string $token,
        Client $client,
        MilestoneResponseMapper $milestoneResponseMapper,
        IssueResponseMapper $issueResponseMapper
    ) {
        $this->client = $client;
        // TODO
        $this->client->authenticate($token, AuthMethod::ACCESS_TOKEN);
        $this->milestoneResponseMapper = $milestoneResponseMapper;
        $this->issueResponseMapper = $issueResponseMapper;
        $this->account = $account;
    }

    /**
     * @return array<MilestoneResponse>
     */
    public function getMilestones(string $token, string $repository): array
    {
        $this->setToken($token);

        return array_map(
            fn (array $data): MilestoneResponse => $this->milestoneResponseMapper->map($data),
            $this->client->api('issues')->milestones()->all($this->account, $repository),
        );
    }

    /**
     * @return array<IssueResponse>
     */
    public function getIssues(string $token, string $repository, int $number): array
    {
        $this->setToken($token);

        return array_map(
            fn (array $data): IssueResponse => $this->issueResponseMapper->map($data),
            $this->client->api('issue')->all($this->account, $repository, [
                'milestone' => $number,
                'state' => 'all',
            ]),
        );
    }

    private function setToken(string $token): void
    {
        $this->client->authenticate($token, AuthMethod::ACCESS_TOKEN);
    }
}
