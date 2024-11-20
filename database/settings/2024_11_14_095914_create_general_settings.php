<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.current_event_id', null);
        $this->migrator->add('general.copyright', 'Copyright 2024');
        $this->migrator->add('general.facebook', 'https://facebook.com');
        $this->migrator->add('general.instagram', 'https://instagram.com');
    }
};
