<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\Leaderboards;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function results()
    {
        return view('games.results');
    }

    public function schedule()
    {
        $games = Game::where('status', 'scheduled')->where('scheduled_at', '>', now())->orderBy('scheduled_at')->paginate(30);
        // dump(now());
        // dd($games);

        return view('games.schedule', ['games' => $games]);
    }

    public function show($slug)
    {
        $game    = Game::where('slug', $slug)->firstOrFail();
        $scorers = Leaderboards::getPlayerLeaderboardForGame($game, 'score', 100);

        return view('games.show', [
            'game'    => $game,
            'scorers' => $scorers,
        ]);
    }

    public function live()
    {
        // Find live game and redirect to it
        $game = Game::where('status', 'in_progress')->first();

        return redirect()->route('games.live.show', $game->slug);
    }

    public function liveShow($slug)
    {
        $game = Game::where('slug', $slug)->where('status', 'in_progress')->firstOrFail();

        return view('games.live', ['game' => $game]);
    }
}
