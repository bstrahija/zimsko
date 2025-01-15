<?php

namespace App\Legacy;

use App\Models\Event;
use App\Services\Settings;
use Illuminate\Support\Facades\DB;

class SyncEvents
{
    public static function run()
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_events')->get()
            ->each(function ($event) {
                // Check if event already exists
                if (Event::where('external_id', $event->wp_id)->first()) return;

                // Set scheduled dated
                if ($event->slug === 'zimsko-2020')     $scheduledAt = '2020-02-02 08:00:00';
                elseif ($event->slug === 'zimsko-2022') $scheduledAt = '2022-02-06 08:00:00';
                elseif ($event->slug === 'zimsko-2023') $scheduledAt = '2023-01-22 08:00:00';
                elseif ($event->slug === 'zimsko-2024') $scheduledAt = '2024-02-02 08:00:00';
                elseif ($event->slug === 'zimsko-2019') $scheduledAt = '2019-02-02 08:00:00';
                elseif ($event->slug === 'zimsko-2021') $scheduledAt = '2021-02-02 08:00:00';
                else                                    $scheduledAt = null;

                $newEvent               = new \App\Models\Event();
                $newEvent->external_id  = $event->wp_id;
                $newEvent->slug         = $event->slug;
                $newEvent->title        = $event->title;
                $newEvent->status       = $event->status;
                $newEvent->data         = @json_decode($event->data);
                $newEvent->created_at   = $event->created_at;
                $newEvent->updated_at   = $event->updated_at;
                $newEvent->scheduled_at = $scheduledAt;
                $newEvent->save();
            });

        // Add missing events (not stats, corona etc.)
        // Event::query()->createOrFirst([
        //     'external_id'  => 9997,
        //     'slug'         => 'zimsko-2019',
        // ], [
        //     'title'        => 'Zimsko 2019',
        //     'status'       => 'archived',
        //     'created_at'   => now(),
        //     'updated_at'   => now(),
        //     'scheduled_at' => '2019-02-02 08:00:00',
        // ]);
        // Event::query()->createOrFirst([
        //     'external_id'  => 9998,
        //     'slug'         => 'zimsko-2021',
        // ], [
        //     'title'        => 'Zimsko 2021',
        //     'status'       => 'canceled',
        //     'created_at'   => now(),
        //     'updated_at'   => now(),
        //     'scheduled_at' => '2021-02-02 08:00:00',
        // ]);

        // Add latest event
        Event::query()->createOrFirst([
            'external_id'  => 9999,
            'slug'         => 'zimsko-2025',
        ], [
            'title'        => 'Zimsko 2025',
            'status'       => 'active',
            'created_at'   => now(),
            'updated_at'   => now(),
            'scheduled_at' => '2025-02-02 08:00:00',
        ]);

        // We also need to set the active event
        Settings::set('general.current_event_id', Event::where('slug', 'zimsko-2025')->first()?->id);
    }
}
