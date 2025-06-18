<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface BookServiceInterface
{
    public function list(array $filters, ?int $limit, ?int $offset): Collection;
    public function listByAuthor(int $authorId, ?int $limit, ?int $offset): Collection;
}
