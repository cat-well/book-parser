<?php

namespace App\Repositories\Contracts;

use App\Models\Author;
use Illuminate\Support\Collection;

interface AuthorRepositoryInterface
{
    public function all(?int $limit = null, ?int $offset = null, ?string $search = null): Collection;
    public function findById(int $authorId): ?Author;
}
