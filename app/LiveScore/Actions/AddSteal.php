<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\LiveScore\Events\StatsAddedToLog;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddSteal
{
    public function handle(int $gameId, int $playerId, ?int $otherPlayerId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $otherPlayerId, $location, $occurredAt) {
            Log::debug("Adding steal. Game: {$gameId}, Player: {$playerId}, From: {$otherPlayerId}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Find players
            $player  = $live->findPlayer($playerId);
            $player2 = $otherPlayerId ? $live->findPlayer($otherPlayerId) : null;

            if ($player) {
                $live->addLog([
                    'type'        => 'player_steal',
                    'subtype'     => 'stl',
                    'player_id'   => $playerId,
                    'player_2_id' => $otherPlayerId ?? null,
                    'amount'      => 1,
                ]);

                // Also write the assist
                if ($otherPlayerId) {
                    $live->addLog([
                        'type'        => 'player_turnover',
                        'subtype'     => 'to',
                        'player_id'   => $otherPlayerId,
                        'player_2_id' => $playerId,
                        'amount'      => 1,
                    ]);
                }
            }
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addSteal', ['playerId' => $playerId]);
    }
}
