<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ParseBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse books from remote JSON by ISBN';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = env('BOOK_JSON_URL', null);

        if (empty($url)) {
            $this->error('Something went wrong');

            return 0;
        }

        $data = Http::get($url)->json();

        if (empty($data)) {
            $this->error('Something went wrong');

            return 0;
        }

        $total = count($data);
        $skipped = [];

        foreach ($data as $index => $value) {
            $ind = $index + 1;
            $percent = intval(($ind / $total) * 100);
            $this->output->write("Processing: {$percent}% ({$ind}/{$total})\r");

            if (empty($value['isbn'])) {
                $skipped[] = $value['title'] ?? 'Unknown title';

                continue;
            }

            $book = Book::updateOrCreate(
                ['isbn' => $value['isbn']],
                [
                    'title' => $value['title'],
                    'page_count' => $value['pageCount'] ?? null,
                    'published_date' => isset($value['publishedDate']['$date']) ? Carbon::parse($value['publishedDate']['$date']) : null,
                    'thumbnail_url' => $value['thumbnailUrl'] ?? null,
                    'short_description' => $value['shortDescription'] ?? null,
                    'long_description' => $value['longDescription'] ?? null,
                    'status' => $value['status'] ?? null,
                ]
            );

            $authorIds = collect($value['authors'] ?? [])->map(fn($author) =>
                Author::firstOrCreate(['name' => $author])->id
            );

            $book->authors()->sync($authorIds);

            $categoryIds = collect($value['categories'] ?? [])->map(fn($category) =>
                Category::firstOrCreate(['name' => $category])->id
            );

            $book->categories()->sync($categoryIds);
        }

        $this->info("\nParsing completed. Skipped books: ");
        if (count($skipped)) {
            foreach ($skipped as $title) {
                $this->warn(" - {$title}");
            }
        } else {
            $this->info("Parsing complete");
        }

        return 0;
    }
}
