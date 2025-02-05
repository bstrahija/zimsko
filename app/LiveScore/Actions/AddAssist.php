<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddAssist
{
    public function handle(int $gameId, int $playerId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playerId) {
            Log::debug("Adding assist. Game: {$gameId}, Player: {$playerId}", ['section' => 'LIVE', 'game_id' => $gameId, 'player_id' => $playerId]);

            // Build live game
            $live = LiveScore::build(Game::find($gameId));

            // Let's check the last log entry, and update with the assisted player
            $side    = $live->homePlayers()->pluck('id')->contains($playerId) ? 'home' : 'away';
            $lastLog = $live->log()->sortByDesc('id')->first();
            if ($lastLog->type === 'player_score' && $lastLog->team_side === $side && $lastLog->player_id !== $playerId && $lastLog->amount > 1) {
                $lastLog->update([
                    'player_2_id'   => $playerId,
                    'player_2_name' => $live->findPlayer($playerId)->name
                ]);
            }

            // Then write the actual assist
            $live->addLog([
                'type'        => 'player_assist',
                'subtype'     => 'ast',
                'player_id'   => $playerId,
                'amount'      => 1,
                'period'      => $live->currentPeriod(),
            ]);
        });

        // Trigger the events
        StatsAddedToLog::dispatch($gameId, []);
        LiveScoreUpdated::dispatch('addScore', ['playerId' => $playerId]);
    }
}
