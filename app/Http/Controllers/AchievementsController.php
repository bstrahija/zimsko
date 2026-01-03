<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Event;

class AchievementsController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('title', 'desc')->get();
        $all    = Achievement::with(['event', 'game', 'team', 'player'])->get();

        return view('achievements.index', ['events' => $events]);
    }
}
