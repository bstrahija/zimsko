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

class ResetGame
{
    public function handle(int $gameId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $location, $occurredAt) {
            Log::debug("Reseting game. Game: {$gameId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            // Build live game
            $game = Game::find($gameId);
            $live = LiveScore::build($game);

            // Clear the log
            GameLog::where('game_id', $gameId)->delete();

            $data = [
                'status'                => 'scheduled',
                'period'                => 1,
                'home_starting_players' => [],
                'home_players_on_court' => [],
                'away_starting_players' => [],
                'away_players_on_court' => [],
            ];

            // Reset stats
            foreach (config('stats.columns') as $column) {
                foreach (['home', 'away'] as $side) {
                    $data[$side . '_' . $column['id']] = 0;
                }
            }

            $live->game()->update($data);

            // Clear the cache
            Cache::clear();


            // Trigger the events
            StatsAddedToLog::dispatch($gameId, []);
            LiveScoreUpdated::dispatch('resetGame', ['gameId' => $game->id]);
        });
    }
}
