<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache as FacadesCache;
use Illuminate\Support\Facades\DB;

class Cache extends FacadesCache
{
    public static function forgetLeaderboards()
    {
        return DB::table('cache')->where('key', 'like', 'event_leaderboard.%')->delete();
    }

    public static function forgetStats()
    {
        return DB::table('cache')->where('key', 'like', 'player_event_stats.%')->delete();
        return DB::table('cache')->where('key', 'like', 'team_event_stats.%')->delete();
    }
}
