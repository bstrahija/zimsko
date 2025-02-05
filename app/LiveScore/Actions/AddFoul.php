<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\LiveScore\Events\StatsAddedToLog;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddFoul
{
    public function handle(int $gameId, int $playerId, string $type = 'pf', ?int $otherPlayerId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId, $type, $otherPlayerId, $location, $occurredAt) {
            Log::debug("Adding foul. Game: {$gameId}, Player: {$playerId}, Foul: {$type}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Find players
            $player  = $live->findPlayer($playerId);

            if ($player) {
                $live->addLog([
                    'type'        => 'player_foul',
                    'subtype'     => $type,
                    'player_id'   => $playerId,
                    'player_2_id' => $otherPlayerId ?? null,
                    'amount'      => 1,
                ]);
            }
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addFoul', ['playerId' => $playerId, 'type' => $type]);
    }
}
