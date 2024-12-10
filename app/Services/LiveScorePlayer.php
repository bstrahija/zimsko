<?php

namespace App\Services;

use App\Models\GameLog;
use App\Models\Player;
use Illuminate\Support\Facades\Log;

trait LiveScorePlayer
{
    public function playerScore(string $playerId, int $points = 2, ?string $playerAssistId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player         = $this->findPlayer($playerId);
        $playerAssisted = $playerAssistId ? $this->findPlayer($playerAssistId) : null;

        // Check players
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerAssisted)) {
            if (! $this->checkPlayer($player)) Log::error('Player not found when adding score', ['section' => 'LIVE', 'player_id' => $playerId, 'player_assist_id' => $playerAssistId]);
            if (! $this->checkPlayer($playerAssisted)) Log::error('Player assisted not found when adding score', ['section' => 'LIVE', 'player_id' => $playerId, 'player_assist_id' => $playerAssistId]);
            Log::debug('Player on court: ' . $this->playersOnCourt->pluck('name')->implode(', '), ['section' => 'LIVE', 'player_id' => $playerId, 'player_assist_id' => $playerAssistId]);
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'        => $playerAssistId ? 'player_score_with_assist' : 'player_score',
                'subtype'     => ($points === 3) ? '3pt' : ($points === 1 ? '1pt' : '2pt'),
                'player_id'   => $player->id,
                'player_2_id' => $playerAssisted ? $playerAssisted->id : null,
                'amount'      => $points,
                'period'      => $this->currentPeriod,
                'location'    => $location,
                'occurred_at' => $occurredAt,
            ]);

            // Also write the assist
            if ($playerAssisted) {
                $this->playerAssist(playerId: $playerAssisted->id, location: $location, occurredAt: $occurredAt);
            }

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerMiss(string $playerId, int $points = 2, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find player
        $player = $this->findPlayer($playerId);

        // Check player
        if (! $this->checkPlayer($player)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'        => 'player_miss',
                'subtype'     => ($points === 3) ? '3pt' : ($points === 1 ? '1pt' : '2pt'),
                'player_id'   => $player->id,
                'amount'      => $points,
                'period'     => $this->currentPeriod,
                'location'    => $location,
                'occurred_at' => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerAssist(string $playerId, ?string $playerAssistToId = null, ?int $points = 0, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find player
        $player           = $this->findPlayer($playerId);
        $playerAssistedTo = $playerAssistToId ? $this->findPlayer($playerAssistToId) : null;

        // Check player
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerAssistedTo)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'        => 'player_assist',
                'subtype'     => 'ast',
                'player_id'   => $player->id,
                'player_2_id' => $playerAssistedTo ? $playerAssistedTo->id : null,
                'amount'      => 1,
                'period'     => $this->currentPeriod,
                'location'    => $location,
                'occurred_at' => $occurredAt,
            ]);

            if ($playerAssistedTo && $points) {
                $this->playerScore(playerId: $playerAssistedTo->id, points: $points, occurredAt: $occurredAt);
            }

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerBlock(string $playerId, ?string $playerBlockedId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player        = $this->findPlayer($playerId);
        $playerBlocked = $playerBlockedId ? $this->findPlayer($playerBlockedId) : null;

        // Check player
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerBlocked)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'            => 'player_block',
                'subtype'         => 'blk',
                'player_id'       => $player->id,
                'player_2_id'     => $playerBlocked ? $playerBlocked->id : null,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerFoul(string $playerId, string $subtype = 'pf', ?string $playerFouledId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player        = $this->findPlayer($playerId);
        $playerFouled  = $playerFouledId ? $this->findPlayer($playerFouledId) : null;
        $foulsLeft     = $this->homePlayers->contains($player) ? $this->homeFoulsLeft : $this->awayFoulsLeft;

        // Check player
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerFouled)) {
            return false;
        }

        if ($player) {
            // Update the fouls
            if ($foulsLeft > 0) $foulsLeft = $foulsLeft - 1;
            $this->homePlayers->contains($player) ? $this->homeFoulsLeft = $foulsLeft : $this->awayFoulsLeft = $foulsLeft;

            $log = $this->addLog([
                'type'            => 'player_foul',
                'subtype'         => $subtype, // can be pf (personal), tf (technical) or ff (flagrant)
                'player_id'       => $player->id,
                'player_2_id'     => $playerFouled ? $playerFouled->id : null,
                'amount'          => 1,
                'period'          => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerRebound(string $playerId, string $subtype = 'reb', ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player = $this->findPlayer($playerId);

        // Check player
        if (! $this->checkPlayer($player)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'            => 'player_rebound',
                'subtype'         => $subtype, // can be reb, oreb or dreb
                'player_id'       => $player->id,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerSteal(string $playerId, ?string $playerStolenId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player       = $this->findPlayer($playerId);
        $playerStolen = $playerStolenId ? $this->findPlayer($playerStolenId) : null;

        // Check player
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerStolen)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'            => 'player_steal',
                'subtype'         => 'stl',
                'player_id'       => $player->id,
                'player_2_id'     => $playerStolen ? $playerStolen->id : null,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerTurnover(string $playerId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find players
        $player = $this->findPlayer($playerId);

        // Check player
        if (! $this->checkPlayer($player)) {
            return false;
        }

        if ($player) {
            $log = $this->addLog([
                'type'            => 'player_turnover',
                'subtype'         => 'to',
                'player_id'       => $player->id,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function substitution(array $playersIn, array $playersOut, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Check if players in/out are the same number
        if (count($playersIn) !== count($playersOut)) {
            Log::error('Players in/out are not the same number.');
            return false;
        }

        foreach ($playersIn as $key => $playerInId) {
            $playerIn  = $this->findPlayer($playerInId);
            $playerOut = $this->findPlayer($playersOut[$key]);

            // We only continue if players in are not on court, and players out are on court
            if ($this->playersOnCourt->contains($playerIn) || ! $this->playersOnCourt->contains($playerOut)) {
                Log::error('Players getting subbed are not on/off court.');
                continue;
            }

            // Remove from court
            $this->playersOnCourt = $this->playersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                return $value->id === $playerOut->id;
            })->values();
            if ($this->homePlayersOnCourt->contains($playerOut)) {
                $this->homePlayersOnCourt = $this->homePlayersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                    return $value->id === $playerOut->id;
                })->values();
            }
            if ($this->awayPlayersOnCourt->contains($playerOut)) {
                $this->awayPlayersOnCourt = $this->awayPlayersOnCourt->reject(static function ($value, $key) use ($playerOut) {
                    return $value->id === $playerOut->id;
                })->values();
            }

            // Add to court
            $this->playersOnCourt->push($playerIn);
            if ($this->homePlayers->contains($playerIn)) {
                $this->homePlayersOnCourt->push($playerIn);
            } else {
                $this->awayPlayersOnCourt->push($playerIn);
            }
            $this->gameLive->update([
                // 'players_on_court'      => $this->playersOnCourt->pluck('id')->toArray(),
                'home_players_on_court' => $this->homePlayersOnCourt->pluck('id')->toArray(),
                'away_players_on_court' => $this->awayPlayersOnCourt->pluck('id')->toArray(),
            ]);

            $log = $this->addLog([
                'type'            => 'substitution',
                'subtype'         => 'sub',
                'player_id'       => $playerIn->id,
                'player_2_id'     => $playerOut->id,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    /**
     * Check if player doing something is actually on court
     *
     * @param  Player $player
     * @return bool
     */
    public function checkPlayer(?Player $player, $throwException = false): bool
    {
        if (! $player) {
            return true;
        }

        if (! $this->playersOnCourt->contains($player)) {
            if ($throwException) {
                throw new \Exception('Player not on court: (' . $player->number .  ') ' . $player->name);
            }

            return false;
        }

        return true;
    }

    public function updateLiveStats(?GameLog $log = null): void
    {
        // Only events with a score update
        $homeScore = GameLog::where('game_id', $this->game->id)
            ->where('game_live_id', $this->gameLive->id)
            ->where('team_side', 'home')
            ->whereIn('type', ['player_score', 'player_score_with_assist'])->sum('amount');
        $awayScore = GameLog::where('game_id', $this->game->id)
            ->where('game_live_id', $this->gameLive->id)
            ->where('team_side', 'away')
            ->whereIn('type', ['player_score', 'player_score_with_assist'])->sum('amount');

        // Update the log item if needed
        if ($log) {
            $log->update([
                'home_score' => $homeScore,
                'away_score' => $awayScore,
            ]);
        }

        // Also update live game stats
        $this->gameLive->update([
            'home_score' => $homeScore,
            'away_score' => $awayScore,
        ]);
    }

    public function findPlayer(string $playerId): ?Player
    {
        return $this->players->where('id', $playerId)->first();
    }

    public function findPlayerByNumber(int $playerNumber): ?Player
    {
        return $this->players->where('number', $playerNumber)->first();
    }
}
