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
        $leaderboard       = Leaderboards::getForEvent(Event::current());
        $leaderboardPoints = Leaderboards::getPointLeadersForEvent(Event::current());
        $leaderboard3Point = Leaderboards::get3PointLeadersForEvent(Event::current());

        return view('index', [
            'currentEvent'      => $currentEvent,
            'latestGames'       => $latestGames,
            'leaderboard'       => $leaderboard,
            'leaderboardPoints' => $leaderboardPoints,
            'leaderboard3Point' => $leaderboard3Point,
        ]);
    }
}
