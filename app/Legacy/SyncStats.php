<?php

namespace App\Legacy;

use App\Services\Stats;
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
