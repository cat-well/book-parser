<?php

namespace App\Services\Contracts;

use App\Models\Author;
use Illuminate\Support\Collection;

interface AuthorServiceInterface
{
    public function list(?int $limit, ?int $offset, ?string $search): Collection;
    public function getById(int $authorId): ?Author;
}
