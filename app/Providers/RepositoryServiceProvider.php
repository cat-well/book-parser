<?php

namespace App\Providers;

use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\BookRepositoryInterface;
use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\Eloquent\BookRepository;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\Contracts\AuthorServiceInterface;
use App\Services\Contracts\BookServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
    }
}
