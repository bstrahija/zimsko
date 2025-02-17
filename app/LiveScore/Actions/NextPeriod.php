<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NextPeriod
{
    public function handle(int $gameId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $location, $occurredAt) {
            Log::debug("Next period. Game: {$gameId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            // Build live game
            $game = Game::find($gameId);
            $live = LiveScore::build($game);

            // Update the game live model
            $live->game()->update([
                'period' => $live->currentPeriod() + 1,
            ]);

            // And add a log that the period has started
            $live->addLog([
                'type'        => 'period_started',
                'period'      => $live->currentPeriod() + 1,
            ]);

            // Also clear out the players on court
            $live->game()->update(['home_players_on_court' => [], 'away_players_on_court' => []]);

            // Trigger the events
            StatsAddedToLog::dispatch($gameId, []);
            LiveScoreUpdated::dispatch('nextPeriod', ['gameId' => $game->id]);
        });
    }
}
