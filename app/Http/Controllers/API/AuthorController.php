<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit  = $request->input('limit');
        $offset = $request->input('offset');
        $search = $request->input('search');

        $query = Author::withCount('books');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if (!is_null($offset)) {
            $query->offset((int)$offset);
        }
        if (!is_null($limit)) {
            $query->limit((int)$limit);
        }

        $authors = $query->get();

        return AuthorResource::collection($authors)
            ->additional(['meta' => [
                'limit'  => $limit,
                'offset' => $offset,
                'count'  => $authors->count(),
            ]]);
    }

    public function books(Request $request, Author $author): AnonymousResourceCollection
    {
        $limit  = $request->input('limit');
        $offset = $request->input('offset');

        $query = $author->books()->with(['authors']);

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
