# Book Parser & API in Laravel 12

A Laravel 12 project for importing books from a JSON resource and providing a REST API for data access.

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Environment Configuration](#environment-configuration)
4. [Database Migrations & Data Import](#database-migrations--data-import)
5. [Running the Local Server](#running-the-local-server)
6. [API Endpoints](#api-endpoints)
7. [Artisan Command](#artisan-command)
8. [Examples](#examples)
9. [Logging & Debugging](#logging--debugging)

---

## Requirements

- PHP >= 8.1
- Composer
- MariaDB / MySQL
- Git

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-user/book-parser.git
   cd book-parser
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Generate application key:
   ```bash
   php artisan key:generate
   ```

---

## Environment Configuration

1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Open `.env` and set the following variables:
   ```dotenv
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=book_parser
   DB_USERNAME=root
   DB_PASSWORD=secret

   # JSON source URL for importing books
   BOOK_JSON_URL=https://raw.githubusercontent.com/bvaughn/infinite-list-reflow-examples/refs/heads/master/books.json
   ```
3. (Optional) Adjust other settings as needed.

---

## Database Migrations & Data Import

1. Run database migrations:
   ```bash
   php artisan migrate
   ```
2. Import books from JSON:
   ```bash
   php artisan books:import
   ```
    - The command will display import progress as a percentage.
    - Books without an ISBN will be skipped, and their titles will be listed at the end.

---

## Running the Local Server

```bash
php artisan serve
```

By default, the application will be available at `http://127.0.0.1:8000`.

---

## API Endpoints

All endpoints are prefixed with `/api/v1`.

### 1. List Books

```
GET /api/v1/books
```

#### Query Parameters

- `search` (string) — filter by title, short description, author name, or category.
- `limit` (integer) — number of records to return (all records if not set).
- `offset` (integer) — number of records to skip (0 if not set).

#### Response

```json
{
  "data": [
    {
      "title": "...",
      "short_description": "...",
      "long_description": "...",
      "page_count": 416,
      "thumbnail_url": "...",
      "published_at": "2009-04-01",
      "isbn": "1933988673",
      "status": "PUBLISH",
      "authors": ["W. Frank Ableson", "Charlie Collins", "Robi Sen"],
      "categories": ["Open Source","Mobile"]
    }
  ],
  "meta": {
    "limit": 5,
    "offset": 0,
    "count": 1
  }
}
```

### 2. List Authors

```
GET /api/v1/authors
```

#### Query Parameters

- `search` (string) — filter by author name.
- `limit`, `offset` — same as above.

#### Response

```json
{
  "data": [
    {
      "name": "Charlie Collins",
      "books_count": 10
    }
  ],
  "meta": {
    "limit": 5,
    "offset": 0,
    "count": 1
  }
}
```

### 3. List Books by Author

```
GET /api/v1/authors/{author_id}/books
```

#### Path Parameter

- `author_id` (integer) — the ID of the author.

#### Query Parameters

- `limit`, `offset` — same as above.

#### Response

```json
{
  "data": [  ],
  "meta": { "limit": 5, "offset": 0, "count": 3 }
}
```

---

## Artisan Command

```
books:import
```

#### Description

- Fetches JSON from `BOOK_JSON_URL`.
- Creates or updates records in the `books` table by ISBN.
- Synchronizes relationships with authors and categories.
- Skips books without an ISBN and lists them at the end.
- Displays import progress in percentage.

---

## Examples

```bash
# Import data
php artisan books:import

# Run server
php artisan serve

# Get first 5 books starting at offset 0
curl "http://127.0.0.1:8000/api/v1/books?limit=5&offset=0"

# Search books by keyword
curl "http://127.0.0.1:8000/api/v1/books?search=Android"

# Get first 3 authors
curl "http://127.0.0.1:8000/api/v1/authors?limit=3"

# Get books for author ID 2
curl "http://127.0.0.1:8000/api/v1/authors/2/books?limit=10&offset=0"
```

---

## Logging & Debugging

- Application logs are stored in `storage/logs/laravel.log`.
- To display detailed errors, set `APP_DEBUG=true` in your `.env`.

---

**Author:** Your Name / Development Team

