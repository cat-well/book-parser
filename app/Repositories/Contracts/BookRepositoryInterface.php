<?php
namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface BookRepositoryInterface
{
    public function all(array $filters = [], ?int $limit = null, ?int $offset = null): Collection;
    public function findByAuthor(int $authorId, ?int $limit = null, ?int $offset = null): Collection;
}
