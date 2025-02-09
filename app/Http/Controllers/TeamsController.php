<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Team;
use App\Stats\Stats;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        $event = Event::current();
        $teams = $event->teams()->orderBy('title')->get();

        return view('pages.teams', ['teams' => $teams]);
    }

    public function show($slug, Request $request)
    {
        $team       = Team::where('slug', $slug)->with(['activePlayers', 'activePlayers.media', 'coaches'])->firstOrFail();
        $lastGame   = $team->lastGame();
        $nextGame   = $team->nextGame();
        $teamStats   = Stats::teamEventStats($team->id);
        $playerStats = collect(Stats::teamPlayerEventStats($team->id))->sortByDesc('score')->values()->all();

        return view('pages.team', [
            'team' => $team,
            'lastGame' => $lastGame,
            'nextGame' => $nextGame,
            'teamStats' => $teamStats,
            'playerStats' => $playerStats,
        ]);
    }

    public function showPlayer($slug)
    {
        $player   = Player::where('slug', $slug)->with(['media', 'teams'])->firstOrFail();
        $lastGame = $player->lastGame();

        return view('pages.player', ['player' => $player, 'team' => $player->team, 'lastGame' => $lastGame]);
    }
}
