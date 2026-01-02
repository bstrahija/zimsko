# Admin (Filament 3)

The admin dashboard uses Filament 3 with several plugins:

-   filament/spatie-laravel-settings-plugin (app settings)
-   filament/spatie-laravel-media-library-plugin (media)
-   jeffgreco13/filament-breezy (auth)
-   bezhansalleh/filament-shield (permissions)
-   cms-multi/filament-clear-cache (maintenance)
-   dotswan/filament-laravel-pulse (metrics)
-   tomatophp/filament-users (user management)

## Resources

Located at app/Filament/Resources:

-   TeamResource, PlayerResource, GameResource, RoundResource, OfficialResource
-   PageResource, PostResource, GalleryResource
-   OrderResource, ProductResource (donations/shop)
-   AchievementResource, EventResource

Each resource provides:

-   List -> Create/Edit forms
-   Media management using Spatie Media Library
-   Slugs via spatie/laravel-sluggable where applicable

## Theming

-   Filament theme overrides at resources/css/filament/admin/theme.css (included in Vite inputs)

## Access

-   Admin panel at /admin
-   Authentication via Breezy; authorization via Filament Shield roles/permissions

## Tips

-   If adding new resources, follow existing naming and directory conventions
-   For custom pages or dashboard widgets, keep them under app/Filament and register via Filament service providers
