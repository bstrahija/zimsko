# Laravel Boost (MCP) Guide

Laravel Boost is an MCP server that ships with tooling tailored for this app. Use it to quickly search version-specific docs, run artisan tasks, inspect browser logs, and more.

## What Boost provides

-   search-docs: query Laravel/Filament/Livewire/Inertia/Tailwind/Pest docs with version context
-   list-artisan-commands: discover artisan commands and options
-   tinker and database-query: evaluate PHP or run read-only DB queries for debugging
-   browser-logs: fetch recent client-side logs/exceptions
-   get-absolute-url: generate correct local URLs (Herd `.test` domains or localhost)

## Daily workflows

-   Before coding a feature involving Laravel/Filament/Inertia, run search-docs with a couple of broad queries to confirm the idiomatic approach.
-   When scaffolding: use list-artisan-commands to confirm make:\* options, always pass --no-interaction.
-   For debugging: prefer tinker for Eloquent checks; use database-query for read-only reporting.
-   For frontend issues: check browser-logs to surface recent console errors from the local app.

## Conventions reinforced by Boost

-   Follow Laravel 11 structure and patterns
-   Use Filament resource generators for admin features
-   Use Inertia’s composition (resolve via import.meta.glob) and Vue 3 SFCs
-   Favor Tailwind utilities; avoid ad-hoc CSS files
-   Tests with Pest; run focused tests first, then full suite on demand

## Handy Boost-driven checks

-   URLs: use get-absolute-url when sharing a link in docs or PRs
-   Versioned docs: search-docs ["rate limit", "routing rate limit", "middleware"]
-   Filament actions and tables: search-docs ["table filters", "form relationship select", "testing filament actions"]
-   Livewire v3 specifics: search-docs ["wire:model.live", "dispatch events", "lifecycle hooks"]

## Notes

-   Boost is additive—no code runtime dependency is required in production. It’s a dev assistant aligned with this repo’s conventions.
