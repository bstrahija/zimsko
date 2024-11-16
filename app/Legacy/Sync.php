<?php

namespace App\Legacy;

use App\Models\Post;
use Illuminate\Support\Facades\DB;

class Sync
{
    public static function run()
    {
        SyncPages::run();
        SyncPosts::run();
        SyncCategories::run();
        SyncEvents::run();
        SyncTeams::run();
        SyncPlayers::run();
        SyncCoaches::run();
        SyncReferees::run();
        SyncGames::run();
    }

    public static function clear()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('media')->truncate();
        DB::table('posts')->truncate();
        DB::table('pages')->truncate();
        DB::table('players')->truncate();
        DB::table('games')->truncate();
        DB::table('teams')->truncate();
        DB::table('coaches')->truncate();
        DB::table('referees')->truncate();
        DB::table('events')->truncate();
        // DB::table('player_stats')->truncate();
        // DB::table('team_stats')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
