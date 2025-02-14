<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use App\Services\Cache;
use App\Stats\Stats;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function show($slug)
    {
        $player = Player::where('slug', $slug)->with(['media', 'teams'])->firstOrFail();
        $stats  = Cache::remember('player_event_stats.' . Event::current()->id . '.' . $player->id, (60 * 60 * 24), fn() => Stats::playerEventStats($player->id));

        return view('pages.player', [
            'player'   => $player,
            'team'     => $player->team,
            'lastGame' => $player->lastGame(),
            'stats'    => $stats
        ]);
    }
}
