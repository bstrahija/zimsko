# Architecture Overview

Zimsko is a monorepo-style Laravel app serving:

-   Public site (Livewire/Blade + some vanilla JS enhancements)
-   Admin dashboard (Filament 3)
-   Tablet-friendly live scoring app (Vue 3 via Inertia)

## Backend

-   Laravel 11 (PHP 8.2), routes in routes/web.php
-   Domain-specific modules under app/ (e.g., app/LiveScore)
-   Realtime via Laravel Echo + Pusher
-   Queues used for stats generation (see Jobs/GenerateTotalStats)

### LiveScore module

Located in app/LiveScore. Responsibilities:

-   LiveScore.php: coordination layer for an in-progress game
-   Http/: entry controllers for the Inertia pages that drive the tablet app
-   Actions/: stat mutations (AddScore, AddRebound, Substitution, etc.)
-   Events/: LiveScoreUpdated, StatsAddedToLog broadcast to Echo channel `live-score`
-   Traits/: StatsData, LogData helpers for composition

Key flow:

1. Tablet app emits an HTTP request to ScoreController@update with action payload
2. LiveScore::build($game)->addStatFromRequest($request) routes to the right Action
3. Action appends a row to GameLog and may broadcast LiveScoreUpdated
4. UI listens on Echo channel and updates state optimistically/after confirmation

Data model highlights (see Models/):

-   Game, Team, Player with pivot data for jersey number/position
-   GameLog captures normalized, append-only stat events
-   Config for rules in config/live.php (period length, foul limits, timeouts)

### Admin (Filament)

Located at app/Filament/Resources with resource classes per domain model:

-   TeamResource, PlayerResource, GameResource, RoundResource, etc.
    Plugins in composer.json:
-   filament/spatie-laravel-settings-plugin, media-library, breezy (auth), shield (permissions), and others

### Frontend

-   Vite 5 config in vite.config.js (inputs: resources/css/_.css and resources/js/_.js)
-   Tailwind 3 config in tailwind.config.js (custom colors, fonts, screens)
-   Public site bootstrap in resources/js/app.js (photoswipe, chart.js, Echo notifications)
-   Tablet/Inertia app in resources/js/live.js

## Realtime

-   Echo configured in resources/js/echo.js
-   Public site app.js also creates an Echo instance for site-wide notifications
-   Events broadcast on channel `live-score` with event name App\\LiveScore\\Events\\LiveScoreUpdated

## Routes

-   Public: results, schedule, teams, players, posts, stats, reports
-   Admin: /admin (Filament)
-   Live tablet app (auth required):
    -   /live -> Live games index
    -   /live/{game}/score -> stat input surface (Inertia page 'Score')
    -   /live/{game}/players\*, /live/{game}/starting-players, /live/{game}/players-on-court

## Assets and CSS

-   Tailwind used across site and tablet; theme colors and fonts defined in tailwind.config.js
-   Additional CSS entries: resources/css/report.css and filament theme override at resources/css/filament/admin/theme.css

## Testing

-   Pest configured; see tests/Feature and tests/Unit

## Observability

-   Laravel Pulse, Sentry, Debugbar (dev) are integrated via composer.json

## Developer tooling (Boost)

-   Laravel Boost MCP is available during development. Use it to:
    -   search versioned docs before changing code
    -   list artisan commands and flags when scaffolding
    -   tinker/database-query for data inspection
    -   browser-logs to surface client errors
