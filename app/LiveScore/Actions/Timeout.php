<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Timeout
{
    public function handle(int $gameId, int $teamId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $teamId, $location, $occurredAt) {
            Log::debug("Timeout. Game: {$gameId} Team: {$teamId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            $game = Game::find($gameId);
            $live = LiveScore::build($game);

            // Find the team
            $team = Team::find($teamId);

            $live->addLog([
                'type'    => 'timeout',
                'subtype' => 'team_timeout',
                'team_id' => $team->id,
                'period'  => $live->currentPeriod(),
            ]);

            // Trigger the events
            StatsAddedToLog::dispatch($gameId, []);
            LiveScoreUpdated::dispatch('timeout', ['gameId' => $gameId]);
        });
    }
}
