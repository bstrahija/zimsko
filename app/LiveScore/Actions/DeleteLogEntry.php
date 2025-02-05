<?php

namespace App\LiveScore\Actions;

use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\Events\StatsAddedToLog;
use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Models\GameLog;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteLogEntry
{
    /**
     * This deletes the log entry, but it also needs to revert some other changes made to the stats
     *
     * @param int $logId
     * @param int $playerId
     * @param int $amount
     * @param null|array $location
     * @param null|string $occurredAt
     * @return void
     * @throws BindingResolutionException
     */
    public function handle(int $logId)
    {
        DB::transaction(function () use ($logId) {
            $log = GameLog::find($logId);
            $game = $log->game;
            $live = LiveScore::build($game);
            Log::debug("Deleting log. Game: {$log->game->id} Log: {$log->type}", ['section' => 'LIVE', 'game_id' => $log->game->id]);

            if ($log->type === 'completed' || $log->type === 'game_ended') {
                Log::debug("Reversing completed game. Game: {$log->game->id}", ['section' => 'LIVE', 'game_id' => $log->game->id]);
                $live->game()->update(['status' => 'in_progress']);
            } elseif ($log->type === 'game_started') {
                Log::debug("Reversing started game. Game: {$log->game->id}", ['section' => 'LIVE', 'game_id' => $log->game->id]);
                $live->game()->update(['status' => 'scheduled']);
            } elseif ($log->type === 'period_started') {
                Log::debug("Reversing period started. Game: {$log->game->id}", ['section' => 'LIVE', 'game_id' => $log->game->id]);
                $live->game()->update(['period' => $log->period - 1]);
            } elseif ($log->type === 'substitution') {
                Log::debug("Reversing substitution. Game: {$log->game->id}", ['section' => 'LIVE', 'game_id' => $log->game->id]);
                // TODO: We need to revert the substitution
                app(Substitution::class)->handle(gameId: $log->game->id, playersIn: [$log->player_2_id], playersOut: [$log->player_id], addLog: false);
                // $this->live($log->game)->substitution(playersIn: [$log->player_2_id], playersOut: [$log->player_id], addLog: false);
            }

            // Delete entry
            $log->delete();

            // Trigger events
            LiveScoreUpdated::dispatch('deleteLog', []);
            StatsAddedToLog::dispatch($game->id, []);
        });
    }
}
