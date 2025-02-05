<?php

namespace App\Http\Controllers;

use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Services\Leaderboards;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function results()
    {
        return view('pages.results');
    }

    public function schedule()
    {
        $games = Game::where('status', 'scheduled')
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')->paginate(30);

        return view('pages.schedule', ['games' => $games]);
    }

    public function show($slug)
    {
        $game    = Game::where('slug', $slug)->firstOrFail();
        $scorers = Leaderboards::getPlayerLeaderboardForGame($game, 'score', 100);
        $live    = LiveScore::build($game);

        // return view('pages.empty');

        return view('pages.game', [
            'game'    => $game,
            'scorers' => $scorers,
            'live'    => $live,
        ]);
    }
}
