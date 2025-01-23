<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Post;
use App\Services\Leaderboards;
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

        // Get the latest games
        $upcomingGames      = Game::where(['event_id' => $currentEvent->id])->where(function ($query) {
            $query->where('status', 'scheduled');
            $query->orWhere('status', 'in_progress');
        })->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])->orderBy('scheduled_at')->limit(6)->get();
        $latestGames        = Game::where(['status' => 'completed', 'event_id' => $currentEvent->id])
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])->orderByDesc('scheduled_at')->limit(6)->get();

        // If we dont have games for current event, show past event
        if (! $latestGames || ! $latestGames->count()) {
            $latestGames = Game::where(['status' => 'completed', 'event_id' => $pastEvent->id])
                ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])->orderByDesc('scheduled_at')->limit(6)->get();
        }

        // And the leaderboards (shold be cached)
        $leaderboard        = Cache::remember('event_leaderboard.teams.'  . $currentEvent->id, (60 * 60 * 24), fn() => Leaderboards::getTeamLeaderboardForEvent($currentEvent));
        $leaderboardPoints  = Cache::remember('event_leaderboard.points.' . $currentEvent->id, (60 * 60 * 24), fn() => Leaderboards::getPlayerLeaderboardForEvent($pastEvent));
        $leaderboard3Point  = Cache::remember('event_leaderboard.3pts.'   . $currentEvent->id, (60 * 60 * 24), fn() => Leaderboards::getPlayer3PointLeaderboardForEvent($pastEvent));

        // No caching
        // $leaderboard        = Leaderboards::getTeamLeaderboardForEvent($currentEvent);
        // $leaderboardPoints  = Leaderboards::getPlayerLeaderboardForEvent($pastEvent);
        // $leaderboard3Point  = Leaderboards::getPlayer3PointLeaderboardForEvent($pastEvent);

        // return view('empty');

        return view('index', [
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
}
