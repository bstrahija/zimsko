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
        $game = Game::where('slug', $slug)->firstOrFail();

        // Let's cache if game is over
        if (! $game->isCompleted()) {
            $scorers = Cache::remember('game_scorers.'    . $game->id, (60 * 60 * 24 * 30), fn() => Leaderboards::getPlayerLeaderboardForGame($game, 'score', 100));
            $live    = Cache::remember('game_live_score.' . $game->id, (60 * 60 * 24 * 30), fn() => LiveScore::build($game)->toOptimizedData());
        } else {
            $scorers = Leaderboards::getPlayerLeaderboardForGame($game, 'score', 100);
            $live    = LiveScore::build($game)->toOptimizedData();
        }

        // Also get latest games for both teams
        $homeGames = $game->homeTeam->latestGames();
        $awayGames = $game->awayTeam->latestGames();

        return view('pages.game', [
            'game'      => $game,
            'scorers'   => $scorers,
            'live'      => $live,
            'homeGames' => $homeGames,
            'awayGames' => $awayGames,
        ]);
    }
}
