<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Provider\RepositoriesProvider;

class RepositoriesProvider implements RepositoriesProviderInterface
{
    private const REPOSITORIES_SEPARATOR = '|';

    private array $repositories;

    public function __construct(string $repositories)
    {
        $this->repositories = array_values(
            array_filter(
                array_map(
                    'trim',
                    array_unique(explode(self::REPOSITORIES_SEPARATOR, $repositories)),
                )
            )
        );
    }

    public function provide(): array
    {
        return $this->repositories;
    }
}
