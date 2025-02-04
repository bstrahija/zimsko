<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function show($slug)
    {
        $player   = Player::where('slug', $slug)->with(['media', 'teams'])->firstOrFail();

        return view('pages.player', ['player' => $player, 'team' => $player->team, 'lastGame' => $player->lastGame()]);
    }
}
