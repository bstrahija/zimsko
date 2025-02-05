<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\LiveScore\Events\StatsAddedToLog;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddRebound
{
    public function handle(int $gameId, int $playerId, string $type = 'def', ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $type, $location, $occurredAt) {
            Log::debug("Adding rebound. Game: {$gameId}, Player: {$playerId}, Rebound: {$type}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Find players
            $player  = $live->findPlayer($playerId);

            if ($player) {
                $live->addLog([
                    'type'        => 'player_rebound',
                    'subtype'     => $type,
                    'player_id'   => $playerId,
                    'amount'      => 1,
                ]);
            }
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addRebound', ['playerId' => $playerId]);
    }
}
