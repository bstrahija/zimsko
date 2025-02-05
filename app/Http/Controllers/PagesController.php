<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Post;
use App\Models\Team;
use App\Services\Helpers;
use App\Services\Leaderboards;
use App\Services\Stats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    /**
     * Displays the home page.
     *
     * This page displays the latest news, articles, games and leaderboards.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        // Get data for home page
        $lastEvent          = Event::last()->toArray();
        $currentEvent       = Event::current() ?: ($lastEvent ?: null);
        $pastEvent          = Event::whereNot('id', $currentEvent->id)->whereNot('slug', 'LIKE', '%c-liga%')->orderBy('scheduled_at', 'desc')->first();
        $latestArticles     = Post::orderBy('published_at', 'desc')->take(3)->get();

        // Stats::generateTotalForTeams(generateForEvents: true, generateForGames: true);
        // Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true);

        // $game = Game

        // Get the latest games
        $upcomingGames      = Game::where(['event_id' => $currentEvent->id])->where(function ($query) {
            $query->where('status', 'scheduled');
            $query->orWhere('status', 'in_progress');
        })->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])->orderBy('scheduled_at')->limit(6)->get();
        $latestGames        = Game::where(['status' => 'completed', 'event_id' => $currentEvent->id])
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])->orderByDesc('scheduled_at')->limit(6)->get();

        // // If we don't have games for current event, show past event
        if (! $latestGames || ! $latestGames->count()) {
            $latestGames = Game::where(['status' => 'completed', 'event_id' => $pastEvent->id])
                ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])->orderByDesc('scheduled_at')->limit(6)->get();
        }

        // And the leaderboards (should be cached)
        $leaderboard        = Helpers::leaderboard();
        $leaderboardPoints  = Helpers::leaderboardPoints();
        $leaderboard3Point  = Helpers::leaderboardThreePoints();

        // dump($leaderboardPoints);

        // return view('pages.empty');

        return view('pages.homepage', [
            'currentEvent'      => $currentEvent,
            'latestGames'       => $latestGames,
            'upcomingGames'     => $upcomingGames,
            'leaderboard'       => $leaderboard,
            'leaderboardPoints' => $leaderboardPoints,
            'leaderboard3Point' => $leaderboard3Point,
            'latestArticles'    => $latestArticles,
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        return back()->with('success', 'Poruka je poslana!');
    }

    public function globetka()
    {
        $team = Team::where('slug', 'kk-globetka-cakovec')->firstOrfail();

        // Gel all globetka games
        $games = Game::where('home_team_id', $team->id)
            ->orWhere('away_team_id', $team->id)
            ->orderBy('scheduled_at', 'desc')
            ->paginate(100);

        return view('globetka.index', [
            'games' => $games,
        ]);
    }
}
