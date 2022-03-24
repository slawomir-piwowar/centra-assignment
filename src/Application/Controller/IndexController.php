<?php
declare(strict_types=1);

namespace KanbanBoard\Application\Controller;

use KanbanBoard\Application\Repository\BoardRepositoryInterface;

class IndexController
{
    private BoardRepositoryInterface $boardRepository;

    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function index(): void
    {
        dd($this->boardRepository->getByRepository('centra-assignment'));
    }
}
