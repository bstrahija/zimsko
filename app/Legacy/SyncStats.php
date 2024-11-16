<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class SyncStats
{
    public static function run()
    {
        self::syncPlayerStats();
        self::syncTeamStats();
    }

    public static function syncPlayerStats() {}

    public static function syncTeamStats() {}
}
