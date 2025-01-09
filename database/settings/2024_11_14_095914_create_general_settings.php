<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.current_event_id', null);
        $this->migrator->add('general.copyright', 'Copyright 2025');
        $this->migrator->add('general.facebook', 'https://www.facebook.com/ZimskoPrvenstvoCK/');
        $this->migrator->add('general.instagram', 'https://www.instagram.com/zimsko.prvenstvo.cakovec/');
        $this->migrator->add('general.youtube', 'https://www.youtube.com/@zimskokosarkaskoprvenstvoc827');
        $this->migrator->add('general.sponsors', null);
    }
};
