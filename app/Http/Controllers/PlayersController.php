<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Contracts\View\View;

class PlayersController extends Controller
{
    public function show($slug): View
    {
        $player = Player::where('slug', $slug)->with(['media', 'teams'])->firstOrFail();

        return view('pages.player', [
            'player'   => $player,
            'team'     => $player->team,
            'lastGame' => $player->lastGame(),
        ]);
    }
}
