<?php

namespace App\Services;

use App\Repositories\Contracts\BookRepositoryInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Support\Collection;

class BookService implements BookServiceInterface
{
    public function __construct(private BookRepositoryInterface $repository)
    {
    }

    public function list(array $filters, ?int $limit, ?int $offset): Collection
    {
        return $this->repository->all($filters, $limit, $offset);
    }

    public function listByAuthor(int $authorId, ?int $limit, ?int $offset): Collection
    {
        return $this->repository->findByAuthor($authorId, $limit, $offset);
    }
}
