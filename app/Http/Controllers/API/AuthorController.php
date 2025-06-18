<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Services\Contracts\AuthorServiceInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{

    public function __construct(private AuthorServiceInterface $authorService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $authors = $this->authorService->list(
            $request->input('limit'),
            $request->input('offset'),
            $request->input('search')
        );

        return AuthorResource::collection($authors)
            ->additional(['meta' => [
                'limit'  => $request->input('limit'),
                'offset' => $request->input('offset'),
                'count'  => $authors->count(),
            ]]);
    }

    public function books(Request $request, $authorId): AnonymousResourceCollection
    {
        $books = app(BookServiceInterface::class)->listByAuthor(
            $authorId,
            $request->input('limit'),
            $request->input('offset')
        );

        return BookResource::collection($books)
            ->additional(['meta' => [
                'limit'  => $request->input('limit'),
                'offset' => $request->input('offset'),
                'count'  => $books->count(),
            ]]);
    }
}
