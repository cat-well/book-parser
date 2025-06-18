<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
        'page_count',
        'published_date',
        'thumbnail_url',
        'short_description',
        'long_description',
        'status'
    ];

    protected $dates = ['published_date'];
    protected $casts = [
        'published_date' => 'date',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_book', 'book_id', 'category_id');
    }
}
