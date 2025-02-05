<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\LiveScore\Events\StatsAddedToLog;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddTurnover
{
    public function handle(int $gameId, int $playerId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $location, $occurredAt) {
            Log::debug("Adding turnover. Game: {$gameId}, Player: {$playerId}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Find players
            $player  = $live->findPlayer($playerId);

            if ($player) {
                $live->addLog([
                    'type'        => 'player_turnover',
                    'subtype'     => 'to',
                    'player_id'   => $playerId,
                    'amount'      => 1,
                ]);
            }
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addTurnover', ['playerId' => $playerId]);
    }
}
