<?php

namespace App\Services;

use App\Models\GameLog;
use App\Models\GamePlayer;
use App\Models\Player;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait LiveScorePlayer
{
    public function playerScore(int $playerId, int $points = 2, ?int $playerAssistId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerMiss(int $playerId, int $points = 2, ?array $location = null, ?string $occurredAt = '00:00:00')
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerAssist(int $playerId, ?int $playerAssistToId = null, ?int $points = 0, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        // Find player
        $player           = $this->findPlayer($playerId);
        $playerAssistedTo = $playerAssistToId ? $this->findPlayer($playerAssistToId) : null;

        // If we don't have a player assisted to, try to find it by getting the last log message for this team
        if (! $playerAssistedTo) {
            $lastLog = GameLog::where('game_id', $this->game->id)->latest()->first();

            // Only proceed if the team matches, and the score is 2 or 3
            if ($lastLog && $lastLog->type === 'player_score' && $player->teams->pluck('id')->contains($lastLog->team_id) && $lastLog->amount > 1) {
                $playerAssistedTo = $this->findPlayer($lastLog->player_id);

                // Update the last log entry
                $lastLog->update([
                    'player_2_id'   => $player->id,
                    'player_2_name' => $player->name
                ]);
            }
        }

        // Check player
        if (! $this->checkPlayer($player) || ! $this->checkPlayer($playerAssistedTo)) {
            return false;
        }

        if ($player) {

            // Add the assist to log
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerBlock(int $playerId, ?int $playerBlockedId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerFoul(int $playerId, string $subtype = 'pf', ?int $playerFouledId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function teamTechnicalFoul(int $teamId, ?array $location = null, ?string $occurredAt = '00:00:00')
    {
        if ($teamId) {
            $log = $this->addLog([
                'type'            => 'team_technical',
                'subtype'         => 'tf', // can be pf (personal), tf (technical) or ff (flagrant)
                'team_id'         => $teamId,
                'amount'          => 1,
                'period'          => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
        }
    }

    public function playerRebound(int $playerId, string $subtype = 'reb', ?array $location = null, ?string $occurredAt = '00:00:00')
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
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerSteal(int $playerId, ?int $playerStolenId = null, ?array $location = null, ?string $occurredAt = '00:00:00')
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

            // Add a turnover to the player stolen
            if ($playerStolen) {
                $this->playerTurnover(playerId: $playerStolen->id, subtype: 'to_by_stl', occurredAt: $occurredAt);
            }

            // Now update the score
            $this->updateLiveStats(log: $log);
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function playerTurnover(int $playerId, ?array $location = null, $subtype = 'to', ?string $occurredAt = '00:00:00')
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
                'subtype'         => $subtype ?: 'to',
                'player_id'       => $player->id,
                'amount'          => 1,
                'period'         => $this->currentPeriod,
                'location'        => $location,
                'occurred_at'     => $occurredAt,
            ]);

            // Now update the score
            $this->updateLiveStats(log: $log);
            $this->updatePlayerLiveStats(player: $player);
        }
    }

    public function substitution(array $playersIn, array $playersOut, ?array $location = null, ?string $occurredAt = '00:00:00', $addLog = true)
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
            $this->game->update([
                // 'players_on_court'      => $this->playersOnCourt->pluck('id')->toArray(),
                'home_players_on_court' => $this->homePlayersOnCourt->pluck('id')->toArray(),
                'away_players_on_court' => $this->awayPlayersOnCourt->pluck('id')->toArray(),
            ]);

            if (! $addLog) {
                return;
            }

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
            ->where('team_side', 'home')
            ->whereIn('type', ['player_score', 'player_score_with_assist'])->sum('amount');
        $awayScore = GameLog::where('game_id', $this->game->id)
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
        $this->game->update([
            'home_score' => $homeScore,
            'away_score' => $awayScore,
        ]);
    }

    public function updatePlayerLiveStats(Player $player)
    {
        // First get all player log items
        $logs = GameLog::where('game_id', $this->game->id)
            ->where('player_id', $player->id)
            ->get();

        $data = [
            'score'              => $logs->where('type', 'player_score')->sum('amount'),
            'score_p1'           => $logs->where('type', 'player_score')->where('period', 1)->sum('amount'),
            'score_p2'           => $logs->where('type', 'player_score')->where('period', 2)->sum('amount'),
            'score_p3'           => $logs->where('type', 'player_score')->where('period', 3)->sum('amount'),
            'score_p4'           => $logs->where('type', 'player_score')->where('period', 4)->sum('amount'),
            'score_p5'           => $logs->where('type', 'player_score')->where('period', 5)->sum('amount'),
            'score_p6'           => $logs->where('type', 'player_score')->where('period', 6)->sum('amount'),
            'score_p7'           => $logs->where('type', 'player_score')->where('period', 7)->sum('amount'),
            'score_p8'           => $logs->where('type', 'player_score')->where('period', 8)->sum('amount'),
            'score_p9'           => $logs->where('type', 'player_score')->where('period', 9)->sum('amount'),
            'score_p10'          => $logs->where('type', 'player_score')->where('period', 10)->sum('amount'),
            'assists'            => $logs->where('type', 'player_assist')->sum('amount'),
            'steals'             => $logs->where('type', 'player_steal')->sum('amount'),
            'blocks'             => $logs->where('type', 'player_block')->sum('amount'),
            'rebounds'           => $logs->where('type', 'player_rebound')->sum('amount'),
            'offensive_rebounds' => $logs->where('type', 'player_rebound')->where('subtype', 'off')->sum('amount'),
            'defensive_rebounds' => $logs->where('type', 'player_rebound')->where('subtype', 'def')->sum('amount'),
            'turnovers'          => $logs->where('type', 'player_turnover')->sum('amount'),
            'fouls'              => $logs->where('type', 'player_foul')->sum('amount'),
            'personal_fouls'     => $logs->where('type', 'player_foul')->where('subtype', 'pf')->sum('amount'),
            'technical_fouls'    => $logs->where('type', 'player_foul')->where('subtype', 'tf')->sum('amount'),
            'flagrant_fouls'     => $logs->where('type', 'player_foul')->where('subtype', 'ff')->sum('amount'),
            'three_points'       => $logs->where('type', 'player_score')->where('subtype', '3pt')->count() + $logs->where('type', 'player_miss')->where('subtype', '3pt')->count(),
            'three_points_made'  => $logs->where('type', 'player_score')->where('subtype', '3pt')->count(),
            'two_points'         => $logs->where('type', 'player_score')->where('subtype', '2pt')->count() + $logs->where('type', 'player_miss')->where('subtype', '2pt')->count(),
            'two_points_made'    => $logs->where('type', 'player_score')->where('subtype', '2pt')->count(),
            'free_throws'        => $logs->where('type', 'player_score')->where('subtype', '1pt')->count() + $logs->where('type', 'player_miss')->where('subtype', '1pt')->count(),
            'free_throws_made'   => $logs->where('type', 'player_score')->where('subtype', '1pt')->count(),
        ];

        // Add field goals
        $data['field_goals']      = $data['three_points'] + $data['two_points'];
        $data['field_goals_made'] = $data['three_points_made'] + $data['two_points_made'];

        // Update the database
        GamePlayer::updateOrCreate([
            'game_id'  => $this->game->id,
            'player_id' => $player->id,
        ], $data);
    }

    public function findPlayer(int $playerId): ?Player
    {
        return $this->players->where('id', $playerId)->first();
    }

    public function findPlayerByNumber(int $playerNumber): ?Player
    {
        return $this->players->where('number', $playerNumber)->first();
    }

    public function getPlayersBySide(string $side = 'home'): Collection
    {
        $this->{$side . 'Players'} = new Collection;
        // $this->game->players->where('relations.pivot.team_id', $this->game->home_team_id)->toArray()

        foreach ($this->players as $player) {
            if ($player->pivot->team_id === $this->{$side . 'Team'}->id) {
                $this->{$side . 'Players'}->push($player);
            }
        }

        return $this->{$side . 'Players'};
    }
}
