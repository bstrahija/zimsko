# Frontend (Tailwind + Vite + Vue)

This project uses Vite 5 and Tailwind 3 for building both the public site and the tablet app.

## Vite

-   Config in vite.config.js
-   Inputs:
    -   resources/css/app.css (public site)
    -   resources/css/report.css (reports)
    -   resources/js/app.js (public site JS: PhotoSwipe, Chart.js, Echo notifications)
    -   resources/js/live.js (Inertia/Vue tablet app)
    -   resources/css/filament/admin/theme.css (Filament theme override)

## Tailwind

-   Config in tailwind.config.js
-   Custom theme includes brand colors (primary, secondary, accent), fonts (Figtree, Oswald, Roboto, Open Sans), and responsive screens
-   Content scanning includes Blade, JS, and Vue files under resources

## Vue

-   Vue 3 with @vitejs/plugin-vue and Inertia
-   Utilities used: vue-final-modal, @meforma/vue-toaster

## Patterns & conventions

-   Use semantic components and keep logic in helpers where shared (see helpers/live.js)
-   Prefer utility-first CSS; avoid bespoke CSS when Tailwind utilities suffice
-   Keep public site JS progressive: feature-init on DOMContentLoaded, and on Livewire navigations

## Realtime & notifications

-   app.js initializes Echo and may show browser notifications when game events occur
-   Ensure user permission for Notification API is requested gracefully
