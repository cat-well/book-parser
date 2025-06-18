<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Support\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{

    public function all(?int $limit = null, ?int $offset = null, ?string $search = null): Collection
    {
        $query = Author::withCount('books');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($offset) {
            $query->offset($offset);
        }
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function findById(int $authorId): ?Author
    {
        return Author::find($authorId);
    }
}
