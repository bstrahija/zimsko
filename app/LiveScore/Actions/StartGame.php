<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Models\GameLog;
use App\Services\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartGame
{
    public function handle(int $gameId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $location, $occurredAt) {
            Log::debug("Starting game. Game: {$gameId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            $game = Game::find($gameId);
            $live = LiveScore::build($game);
            Cache::clear();

            // Update the game
            $live->game()->update(['period' => 1, 'status' => 'in_progress']);

            // If the game was already started, and completed or something, don't add to log
            $writeToLog = $live->log()->where('type', 'game_started')->count() === 0;

            // We also need to update the log
            if ($writeToLog) {
                GameLog::query()->updateOrCreate([
                    'game_id'      => $gameId,
                    'type'         => 'game_started',
                ], [
                    'period'        => 1,
                ]);
            }

            // Setup the players
            $live->setupPlayers();

            // And update the log collection
            $live->refreshLog();

            // Trigger the events
            StatsAddedToLog::dispatch($gameId, []);
            LiveScoreUpdated::dispatch('startGame', ['gameId' => $gameId]);
        });
    }
}
