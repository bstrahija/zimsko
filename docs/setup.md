# Setup and Local Development

This project uses Laravel 11 (PHP 8.2), Vite 5, Vue 3, Tailwind 3, Filament 3, and Inertia. Realtime events are delivered via Pusher.

Tip: This repo includes Laravel Boost (MCP). Use it for:

-   discovering artisan commands
-   searching versioned docs (Laravel, Filament, Inertia, Livewire, Tailwind, Pest)
-   quick tinker/database checks

## Requirements

-   PHP 8.2+
-   Composer
-   Node 18+ (for Vite 5)
-   SQLite (default) or MySQL (optional)

## 1) Install dependencies

-   composer install
-   npm install

## 2) Environment

-   Copy .env.example to .env
-   Ensure database/database.sqlite exists (composer script creates it on first run)
-   Configure broadcasting (Pusher) keys if using realtime:
    -   VITE_PUSHER_APP_KEY
    -   VITE_PUSHER_APP_CLUSTER

## 3) Database

-   php artisan migrate --graceful
-   php artisan db:seed (optional if seeders exist)

## 4) Run locally

Use the one-liner that starts PHP server, queue listener, logs (Pail), and Vite via composer script:

-   composer run dev

Alternatively, run separately:

-   php artisan serve
-   php artisan queue:listen --tries=1
-   php artisan pail
-   npm run dev

Visit http://localhost:8000

If you use Laravel Herd locally, the site is typically available at https://zimsko.test

## 5) Admin login

The admin is built on Filament. After seeding or creating a user, visit:

-   /admin

## 6) Building assets for production

-   npm run build

Artifacts are output to public/build by Vite.

## 7) Tests

The project uses Pest. To run tests:

-   ./vendor/bin/pest

## Troubleshooting

-   If styles don’t update, clear caches:
    -   php artisan view:clear && php artisan cache:clear && php artisan route:clear
-   If Echo isn’t connecting, verify Pusher keys and that laravel-echo is configured in resources/js/echo.js
-   If Filament pages 404, run php artisan filament:upgrade and check routes cache.

## Boost quickstart

-   See docs/boost.md for Boost tools and common workflows.
