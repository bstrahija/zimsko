<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Services\Leaderboards;

class PagesController extends Controller
{
    public function index()
    {
        $lastEvent         = Event::last()->toArray();
        $currentEvent      = Event::current();
        $latestGames       = Game::where('status', 'completed')->limit(5)->get();
        $upcomingGames     = Game::where('status', 'upcoming')->get();
        $leaderboard       = Leaderboards::getTeamLeaderboardForEvent(Event::current());
        $leaderboardPoints = Leaderboards::getPlayerLeaderboardForEvent(Event::current());
        $leaderboard3Point = Leaderboards::getPlayer3PointLeaderboardForEvent(Event::current());

        return view('index', [
            'currentEvent'      => $currentEvent,
            'latestGames'       => $latestGames,
            'upcomingGames'     => $upcomingGames,
            'leaderboard'       => $leaderboard,
            'leaderboardPoints' => $leaderboardPoints,
            'leaderboard3Point' => $leaderboard3Point,
        ]);
    }
}
