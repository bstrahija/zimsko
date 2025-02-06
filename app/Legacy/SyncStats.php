<?php

namespace App\Legacy;

use App\Models\Event;
use App\Stats\Stats;
use Illuminate\Support\Facades\DB;

class SyncStats
{
    public static function run()
    {
        self::syncTeamStats();
        self::syncPlayerStats();
    }

    public static function syncPlayerStats()
    {
        Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true);
    }

    public static function syncTeamStats()
    {
        Stats::generateTotalForTeams(generateForEvents: true, generateForGames: true);
    }
}
