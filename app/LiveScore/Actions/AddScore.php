<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\LiveScore\Events\StatsAddedToLog;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddScore
{
    public function handle(int $gameId, int $playerId, int $amount = 2, ?int $otherPlayerId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $amount, $otherPlayerId, $location, $occurredAt) {
            Log::debug("Adding score. Game: {$gameId}, Player: {$playerId}, Assist: {$otherPlayerId}, Score: {$amount}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Find players
            $player  = $live->findPlayer($playerId);
            $player2 = $otherPlayerId ? $live->findPlayer($otherPlayerId) : null;

            if ($player) {
                $live->addLog([
                    'type'        => $otherPlayerId ? 'player_score_with_assist' : 'player_score',
                    'subtype'     => ($amount === 3) ? '3pt' : ($amount === 1 ? '1pt' : '2pt'),
                    'player_id'   => $playerId,
                    'player_2_id' => $otherPlayerId ?? null,
                    'amount'      => $amount,
                ]);

                // Also write the assist
                if ($otherPlayerId) {
                    $live->addLog([
                        'type'        => 'player_assist',
                        'subtype'     => 'ast',
                        'player_id'   => $otherPlayerId,
                        'player_2_id' => $playerId,
                        'amount'      => 1,
                    ]);
                }
            }
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addScore', ['playerId' => $playerId,]);
    }
}
