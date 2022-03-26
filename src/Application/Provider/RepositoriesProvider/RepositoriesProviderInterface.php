<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Provider\RepositoriesProvider;

interface RepositoriesProviderInterface
{
    /**
     * @return array<string>
     */
    public function provide(): array;
}
