<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public bool $site_active;

    public ?string $current_event_id;

    public string $copyright;

    public string $facebook;

    public string $instagram;

    public static function group(): string
    {
        return 'general';
    }
}
