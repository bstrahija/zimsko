<?php

namespace App\Http\Controllers;

use App\LiveScore\LiveScore;
use App\Models\Event;
use App\Models\Game;
use App\Models\Stat;
use App\Models\Team;
use App\Services\Cache;
use App\Services\Leaderboards;
use App\Stats\Stats;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        // Let's get all player stats for current event (players and teams)
        $teams       = Event::current(['teams', 'teams.media'])->teams;
        $teamStats   = Cache::remember('team_event_stats.leaders.' .   Event::current()->id, (60 * 60 * 24), fn() => Stats::teamEventStats());
        $playerStats = Cache::remember('player_event_stats.leaders.' . Event::current()->id, (60 * 60 * 24), fn() => Stats::playersEventStats());

        return view('pages.stats', [
            'teams'       => $teams,
            'playerStats' => $playerStats,
            'teamStats'   => $teamStats
        ]);
    }
}
