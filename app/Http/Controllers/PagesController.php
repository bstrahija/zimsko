<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $latestGames = Game::where('status', 'completed')->limit(5)->get();

        return view('index', [
            'latestGames' => $latestGames,
        ]);
    }
}
