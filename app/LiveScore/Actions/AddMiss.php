<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddMiss
{
    public function handle(int $gameId, int $playerId, int $amount = 2, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $amount, $location, $occurredAt) {
            Log::debug("Adding miss. Game: {$gameId}, Player: {$playerId}, Miss: {$amount}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            $live->addLog([
                'type'        => 'player_miss',
                'subtype'     => ($amount === 3) ? '3pt' : ($amount === 1 ? '1pt' : '2pt'),
                'player_id'   => $playerId,
                'amount'      => $amount,
                'period'      => $live->currentPeriod(),
                'location'    => $location,
                'occurred_at' => $occurredAt,
            ]);
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addMiss', ['playerId' => $playerId]);
    }
}
