<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function results()
    {
        return view('games.results');
    }

    public function schedule()
    {
        return view('games.schedule');
    }
}
