# ChirperApp

A Twitter-like social feed built with Laravel. Users can register, post short messages (chirps), like and bookmark chirps, and view user profiles with activity stats.

## Features

- User authentication (register, login, logout)
- Create, edit, and delete chirps
- Authorization policies for chirp ownership
- Like and unlike chirps
- Bookmark and unbookmark chirps
- Dedicated bookmarked chirps feed
- User profile pages with simple stats
- Tailwind CSS + Vite frontend pipeline

## Tech Stack

- Backend: Laravel 12, PHP 8.2+
- Frontend: Blade, Tailwind CSS 4, Vite
- Database: SQLite (default local/testing), MySQL support via Docker image
- Testing: Pest / PHPUnit
- Containerization: Docker (multi-stage build)

## Project Structure

- `app/Http/Controllers` - HTTP controllers (chirps, auth, likes, bookmarks, users)
- `app/Models` - Eloquent models (`User`, `Chirp`, `Like`, `Bookmark`)
- `database/migrations` - schema definitions
- `resources/views` - Blade templates
- `routes/web.php` - web routes

## Quick Start (Local Development)

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- npm

### Installation

```bash
git clone https://github.com/DevMo21x/ChirperApp.git
cd ChirperApp
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
```

### Run the App

Run backend and frontend in separate terminals:

```bash
php artisan serve
```

```bash
npm run dev
```

Open `http://127.0.0.1:8000`.

### One-command Dev Workflow

You can also use the Composer script that starts Laravel + Vite + queue/log processes:

```bash
composer dev
```

## Database

Core app tables:

- `users`
- `chirps`
- `likes` (unique `user_id + chirp_id`)
- `bookmarks` (unique `user_id + chirp_id`)

Run migrations:

```bash
php artisan migrate
```

Refresh database:

```bash
php artisan migrate:fresh
```

## Testing

Run all tests:

```bash
php artisan test
```

or:

```bash
composer test
```

## Docker

This repo includes a Dockerfile that:

- Builds frontend assets with Node
- Runs Laravel on `php:8.3-apache`
- Runs migrations on container start via `entrypoint.sh`

Example:

```bash
docker build -t chirper-app .
docker run --rm -p 8080:80 --env-file .env chirper-app
```

Then open `http://localhost:8080`.

## Main Routes

- `GET /` - home feed
- `POST /chirps` - create chirp (auth)
- `GET /chirps/{chirp}/edit` - edit page (auth)
- `PUT /chirps/{chirp}` - update chirp (auth)
- `DELETE /chirps/{chirp}` - delete chirp (auth)
- `POST /chirps/{chirp}/like` - like chirp (auth)
- `DELETE /chirps/{chirp}/like` - unlike chirp (auth)
- `GET /bookmarks` - bookmarked chirps (auth)
- `POST /chirps/{chirp}/bookmark` - bookmark chirp (auth)
- `DELETE /chirps/{chirp}/bookmark` - remove bookmark (auth)
- `GET /users/{user}` - user profile
- `GET /register`, `POST /register`
- `GET /login`, `POST /login`
- `POST /logout`

## Notes

This project was developed as a multi-phase Laravel assignment and extended with additional social features (likes, bookmarks, profile stats).

## License

This project is licensed under the MIT License.
