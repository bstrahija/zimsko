<?php

namespace App\LiveScore\Actions;

use App\Jobs\GenerateTotalStats;
use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Models\GameLog;
use App\Services\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EndGame
{
    public function handle(int $gameId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $location, $occurredAt) {
            Log::debug("Ending game. Game: {$gameId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            $game = Game::find($gameId);
            $live = LiveScore::build($game);
            Cache::clear();

            // Update the game
            $live->game()->update(['status' => 'completed']);

            // Get the last log entry
            $log = $live->log()->sortByDesc('id')->first();

            // We also need to update the log
            GameLog::query()->updateOrCreate([
                'game_id' => $gameId,
                'type'    => 'game_ended',
            ], [
                'home_score' => $log?->home_score,
                'away_score' => $log?->away_score,
                'period'     => $game->period,
            ]);

            // And update the log collection
            $live->refreshLog();

            // Trigger the events
            StatsAddedToLog::dispatch($gameId, []);
            LiveScoreUpdated::dispatch('endGame', ['gameId' => $gameId]);
            GenerateTotalStats::dispatch($game->event);
        });
    }
}
