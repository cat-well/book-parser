<?php

namespace App\Services;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Services\Contracts\AuthorServiceInterface;
use Illuminate\Support\Collection;

class AuthorService implements AuthorServiceInterface
{

    public function __construct(private AuthorRepositoryInterface $repository)
    {
    }

    public function list(?int $limit, ?int $offset, ?string $search): Collection
    {
        return $this->repository->all($limit, $offset, $search);
    }

    public function getById(int $authorId): ?Author
    {
        return $this->repository->findById($authorId);
    }
}
