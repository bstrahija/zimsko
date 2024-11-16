<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class SyncEvents
{
    public static function run()
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_events')->get()
            ->each(function ($event) {
                $newEvent              = new \App\Models\Event();
                $newEvent->external_id = $event->wp_id;
                $newEvent->slug        = $event->slug;
                $newEvent->title       = $event->title;
                $newEvent->status      = $event->status;
                $newEvent->data        = @json_decode($event->data);
                $newEvent->created_at  = $event->created_at;
                $newEvent->updated_at  = $event->updated_at;
                $newEvent->save();
            });
    }
}
