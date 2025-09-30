# Copilot Guidelines for Zimsko

These guidelines help AI code assistants generate changes consistent with this codebase.

## Project stack

-   Laravel 11 (PHP 8.2), Filament 3 admin, Livewire 3
-   Vue 3 (Inertia) tablet app for live stats
-   Vite 5 + Tailwind 3
-   Realtime via Laravel Echo + Pusher

## Use Laravel Boost (MCP)

-   Before proposing or generating code, search docs via Boost’s search-docs with a few broad queries.
-   When scaffolding, consult list-artisan-commands and pass --no-interaction with proper flags.
-   For debugging, use tinker or database-query; prefer this over ad-hoc temporary scripts.

## Conventions

-   PHP: PSR-12, typed properties and return types; use constructor promotion when readable
-   Controllers thin; push domain logic into services/Actions (see app/LiveScore/Actions)
-   Eloquent: eager-load relations to avoid N+1; prefer query scopes
-   Naming: kebab-case routes, StudlyCase resources, snake_case DB columns
-   Frontend: utility-first Tailwind, Vue SFCs in resources/js, Inertia pages in resources/js/Pages
-   Events and broadcasting: broadcast on channel 'live-score'; event names qualified (e.g., App\\LiveScore\\Events\\LiveScoreUpdated)

## When adding features

-   Backend
    -   Put domain logic in app/LiveScore (or appropriate domain) using Actions
    -   Update config/live.php if introducing new GameLog types or rule constants
    -   Add migrations, factories, and tests (Pest)
    -   Queue heavy computations (Jobs) and broadcast events as needed
-   Admin
    -   Add Filament Resources under app/Filament/Resources; keep forms/tables consistent
    -   Use Spatie Media Library for uploads; use Sluggable where needed
-   Frontend
    -   Register new Inertia pages under resources/js/Pages and import via import.meta.glob
    -   Follow existing modal API patterns in helpers/live.js
    -   Update vite.config.js inputs only if new standalone entry points are required
    -   Keep Tailwind classes consistent with theme tokens (primary, secondary, etc.)

## Testing & quality

-   Write at least a happy-path Pest test; add one edge case
-   Run ./vendor/bin/pest before committing significant changes
-   Use php artisan pint for styling and phpstan if configured
-   Prefer Boost to run focused tests and linting checks if available in your environment

## Realtime & Echo

-   Use resources/js/echo.js for Echo bootstrapping; reuse the global Echo instance
-   Prefer channel names and event payloads that match existing patterns

## Performance & DX

-   Minimize roundtrips by eager-loading relations in controllers/services
-   Avoid re-rendering heavy Vue components; prefer v-if + keyed lists
-   Keep bundle size in check: prefer dynamic imports for rarely used modals

## Code examples

-   Adding a stat Action: create app/LiveScore/Actions/AddAssist.php and wire to LiveScore::addStatFromRequest
-   Inertia page addition: create resources/js/Pages/NewPage.vue and link via import.meta.glob in live.js

## Do not

-   Commit secrets; use .env and VITE\_ variables for frontend
-   Bypass Actions by writing directly to GameLog from controllers
-   Add global CSS when Tailwind utilities can express the style

## See also

-   docs/boost.md for the Boost tool list and common workflows
