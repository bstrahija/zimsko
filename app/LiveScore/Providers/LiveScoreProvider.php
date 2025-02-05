<?php

namespace App\LiveScore\Providers;

use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LiveScoreProvider extends ServiceProvider
{
    public static function boot()
    {
        Event::listen(function (StatsAddedToLog $event) {
            $live = LiveScore::build(Game::find($event->gameId));
            $live->updateLogScore();
            $live->updateGameDataFromLog();
        });
    }
}
