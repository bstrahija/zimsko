<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Models\Team;
use App\Services\Stats;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        $event = Event::current();
        $teams = $event->teams()->orderBy('title')->get();

        return view('teams.index', ['teams' => $teams]);
    }

    public function show($slug, Request $request)
    {
        $team = Team::where('slug', $slug)->with(['activePlayers', 'activePlayers.media', 'coaches'])->firstOrFail();

        return view('teams.show', ['team' => $team]);
    }

    public function showPlayer($slug)
    {
        // Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true);

        $player   = Player::where('slug', $slug)->with(['media', 'teams'])->firstOrFail();
        $lastGame = $player->lastGame();

        return view('players.show', ['player' => $player, 'team' => $player->team, 'lastGame' => $lastGame]);
    }
}
