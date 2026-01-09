<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\Cache;
use App\Stats\Stats;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Let's get all player stats for current event (players and teams)
        $teams = Event::current(['teams', 'teams.media'])->teams;
        // $teamStats   = Cache::remember('team_event_stats.leaders.' .   Event::current()->id, (60 * 60 * 24), fn() => Stats::teamEventStats());
        // $playerStats = Cache::remember('player_event_stats.leaders.' . Event::current()->id, (60 * 60 * 24), fn() => Stats::playersEventStats());
        $officials = DB::table('games')
            ->where('games.event_id', Event::current()->id)
            ->join('game_official', 'games.id', '=', 'game_official.game_id')
            ->join('officials', 'game_official.official_id', '=', 'officials.id')
            ->select('officials.first_name', 'officials.last_name', DB::raw('COUNT(*) as games_officiated'))
            ->groupBy('officials.id', 'officials.first_name', 'officials.last_name')
            ->orderBy('games_officiated', 'desc')
            ->get();

        return view('pages.stats', [
            'teams' => $teams,
            // 'playerStats' => $playerStats,
            // 'teamStats'   => $teamStats,
            'officials' => $officials,
        ]);
    }
}
