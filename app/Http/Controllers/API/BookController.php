<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{

    public function __construct(private BookServiceInterface $bookService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $books = $this->bookService->list(
            ['search' => $request->input('search')],
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
