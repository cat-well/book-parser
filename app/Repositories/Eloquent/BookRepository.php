<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Support\Collection;

class BookRepository implements BookRepositoryInterface
{

    public function all(array $filters = [], ?int $limit = null, ?int $offset = null): Collection
    {
        $query = Book::with(['authors', 'categories']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('long_description', 'like', "%{$search}%")
                ->orWhereHas('authors', fn($qb) => $qb->where('name', 'like', "%{$search}%")->orWhere('id', $search));
        }

        if ($offset) {
            $query->offset($offset);
        }
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function findByAuthor(int $authorId, ?int $limit = null, ?int $offset = null): Collection
    {
        $query = Book::with(['authors'])
            ->whereHas('authors', fn($qb) => $qb->where('id', $authorId));

        if ($offset) {
            $query->offset($offset);
        }
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
