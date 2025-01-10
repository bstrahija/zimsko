<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
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
        $team = Team::where('slug', $slug)->firstOrFail();

        return view('teams.show', ['team' => $team]);
    }
}
