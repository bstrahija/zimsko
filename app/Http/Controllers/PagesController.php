<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\Post;
use App\Services\Helpers;
use App\Stats\Stats;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Displays the home page.
     *
     * This page displays the latest news, articles, games and leaderboards.
     *
     * @return View
     */
    public function index()
    {
        // Get data for home page
        $lastEvent           = Event::last()->toArray();
        $currentEvent        = Event::current() ?: ($lastEvent ?: null);
        $currentAllStarEvent = Event::currentAllStar() ?: null;
        $pastEvent           = Event::whereNot('id', $currentEvent->id)->whereNot('slug', 'LIKE', '%c-liga%')->orderBy('scheduled_at', 'desc')->first();
        $latestArticles      = Post::query()->orderBy('published_at', 'desc')->take(3)->get();

        dump($currentAllStarEvent);

        // $teamEventStats = Stats::teamEventStats(eventId: 10);
        // dump($teamEventStats);
        // $teamEventStats = Stats::teamEventStats(eventId: 8);
        // dump($teamEventStats);

        // $playerEventStats = Stats::playersEventStats(eventId: 10);
        // dump($playerEventStats);
        // $playerEventStats = Stats::playersEventStats(eventId: 8);
        // dump($playerEventStats);

        // Stats::generateTotalForTeams(generateForEvents: true, generateForGames: true);
        // Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true);

        // $game = Game

        $eventIds = [$currentEvent->id];
        if ($currentAllStarEvent) {
            $eventIds[] = $currentAllStarEvent->id;
        }

        // Get the latest games
        $upcomingGames = Game::query()->whereIn('event_id', $eventIds)
            ->where(function ($query) {
                $query->where('status', 'scheduled');
                $query->orWhere('status', 'in_progress');
            })
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])
            ->orderBy('scheduled_at')
            ->limit(6)
            ->get();
        $latestGames = Game::query()->whereIn('event_id', $eventIds)
            ->where('status', 'completed')
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])
            ->orderByDesc('scheduled_at')
            ->limit(6)
            ->get();

        // If we don't have games for current event, show past event
        if (! $latestGames || ! $latestGames->count()) {
            $latestGames = Game::query()->where(['status' => 'completed', 'event_id' => $pastEvent->id])
                ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'round', 'event'])
                ->orderByDesc('scheduled_at')
                ->limit(6)
                ->get();
        }

        // And the leaderboards (should be cached)
        $leaderboard       = Helpers::leaderboard();
        $leaderboardPoints = Helpers::leaderboardPoints();
        $leaderboard3Point = Helpers::leaderboardThreePoints();

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

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        return back()->with('success', 'Poruka je poslana!');
    }
}
