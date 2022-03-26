<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Provider\TokenProvider;

interface TokenProviderInterface
{
    public function provide(): string;
}
