<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('books', [BookController::class, 'index']);
    Route::get('authors', [AuthorController::class, 'index']);
    Route::get('authors/{author}/books', [AuthorController::class, 'books']);
});
