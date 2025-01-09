<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function show(Player $player)
    {
        return view('players.show');
    }
}
