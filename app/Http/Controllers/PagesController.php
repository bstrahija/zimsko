<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Post;
use App\Services\Leaderboards;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        // Get data for home page
        $lastEvent          = Event::last()->toArray();
        $currentEvent       = Event::current() ?: ($lastEvent ?: null);
        $latestGames        = Game::where(['status' => 'completed', 'event_id' => $currentEvent->id])->with(['homeTeam', 'awayTeam'])->orderByDesc('scheduled_at')->limit(6)->get();
        $upcomingGames      = Game::where(['event_id' => $currentEvent->id])->where(function ($query) {
            $query->where('status', 'scheduled');
            $query->orWhere('status', 'in_progress');
        })->with(['homeTeam', 'awayTeam'])->orderBy('scheduled_at')->limit(6)->get();
        $leaderboard        = Leaderboards::getTeamLeaderboardForEvent($currentEvent);
        $leaderboardPoints  = Leaderboards::getPlayerLeaderboardForEvent($currentEvent);
        $leaderboard3Point  = Leaderboards::getPlayer3PointLeaderboardForEvent($currentEvent);
        $latestArticles     = Post::orderBy('published_at', 'desc')->take(3)->get();

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
