<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit  = $request->input('limit');
        $offset = $request->input('offset');
        $search = $request->input('search');

        $query = Book::with(['authors', 'categories']);

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('long_description', 'like', "%{$search}%")
                ->orWhereHas('authors', fn($qb) => $qb->where('name', 'like', "%{$search}%")->orWhere('id', $search));
        }

        if (!is_null($offset)) {
            $query->offset((int)$offset);
        }
        if (!is_null($limit)) {
            $query->limit((int)$limit);
        }

        $books = $query->get();

        return BookResource::collection($books)
            ->additional(['meta' => [
                'limit'  => $limit,
                'offset' => $offset,
                'count'  => $books->count(),
            ]]);
    }
}
