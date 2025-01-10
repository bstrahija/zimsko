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
        $results = Game::where('status', 'scheduled')->where('scheduled_at', '>', now()->format('Y-m-d H:i'))->orderBy('scheduled_at')->paginate(20);

        return view('games.schedule', ['results' => $results]);
    }
}
