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

class Substitution
{
    public function handle(int $gameId, array $playersIn, array $playersOut, bool $addLog = true, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        DB::transaction(function () use ($gameId, $playersIn, $playersOut, $addLog, $location, $occurredAt) {
            Log::debug("Sub. Game: {$gameId}", ['section' => 'LIVE', 'game_id' => $gameId]);

            if (count($playersIn) !== count($playersOut)) {
                Log::error('Players in/out are not the same number.');
                return false;
            }

            $game = Game::find($gameId);
            $live = LiveScore::build($game);

            foreach ($playersIn as $key => $playerInId) {
                $playerIn  = $live->findPlayer($playerInId);
                $playerOut = $live->findPlayer($playersOut[$key]);

                // Remove from court
                $live->playersOnCourt = $live->playersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                    return $value->id === $playerOut->id;
                })->values();
                if ($live->homePlayersOnCourt->contains($playerOut)) {
                    $live->homePlayersOnCourt = $live->homePlayersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                        return $value->id === $playerOut->id;
                    })->values();
                }
                if ($live->awayPlayersOnCourt->contains($playerOut)) {
                    $live->awayPlayersOnCourt = $live->awayPlayersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                        return $value->id === $playerOut->id;
                    })->values();
                }

                // Add to court
                $live->playersOnCourt->push($playerIn);
                if ($live->homePlayers()->contains($playerIn)) {
                    $live->homePlayersOnCourt->push($playerIn);
                } else {
                    $live->awayPlayersOnCourt->push($playerIn);
                }
                $live->game()->update([
                    // 'players_on_court'      => $this->playersOnCourt->pluck('id')->toArray(),
                    'home_players_on_court' => $live->homePlayersOnCourt->pluck('id')->toArray(),
                    'away_players_on_court' => $live->awayPlayersOnCourt->pluck('id')->toArray(),
                ]);

                if ($addLog) {
                    $live->addLog([
                        'type'            => 'substitution',
                        'subtype'         => 'sub',
                        'player_id'       => $playerIn->id,
                        'player_2_id'     => $playerOut->id,
                        'amount'          => 1,
                        'period'          => $live->currentPeriod(),
                    ]);
                }

                // Trigger the events
                StatsAddedToLog::dispatch($gameId, []);
                LiveScoreUpdated::dispatch('substitution', ['gameId' => $gameId]);
            }
        });
    }
}
