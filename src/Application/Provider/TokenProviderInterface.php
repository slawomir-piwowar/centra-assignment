<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Provider;

interface TokenProviderInterface
{
    public function provide(): string;
}
