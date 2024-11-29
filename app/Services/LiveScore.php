<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameLive;
use App\Models\GameLog;
use App\Models\Team;
use Illuminate\Support\Collection;

class LiveScore
{
    use LiveScoreLog, LiveScorePlayer;

    protected Game $game;

    protected GameLive $gameLive;

    protected ?Team $homeTeam;

    protected ?Team $awayTeam;

    protected ?Collection $players;

    protected ?Collection $homePlayers;

    protected ?Collection $awayPlayers;

    protected int $currentQuarter = 1;

    protected ?Collection $playersOnCourt;

    protected ?Collection $homePlayersOnCourt;

    protected ?Collection $awayPlayersOnCourt;

    protected int $homeTimeoutsLeft;

    protected int $awayTimeoutsLeft;

    protected int $homeFoulsLeft;

    protected int $awayFoulsLeft;

    public function __construct(Game|string $game)
    {
        // First find the game model
        if (is_string($game)) {
            $this->game = Game::find($game);
        } else {
            $this->game = $game;
        }

        // We need to preload the teams and players to avoid N+1
        $this->homeTeam    = $this->game->homeTeam()->with(['players'])->first();
        $this->awayTeam    = $this->game->awayTeam()->with(['players'])->first();
        $this->homePlayers = $this->game->homePlayers;
        $this->awayPlayers = $this->game->awayPlayers;
        $this->players     = $this->homePlayers->merge($this->awayPlayers);

        // Init players on court
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        // Init timeouts and fouls
        $this->homeTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->awayTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->homeFoulsLeft    = config('live.team_fouls_per_quarter');
        $this->awayFoulsLeft    = config('live.team_fouls_per_quarter');

        $this->initGame();
    }

    public function initGame()
    {
        // This simply creates the game live model
        $this->gameLive       = $this->game->live()->firstOrCreate([]);
        $this->currentQuarter = $this->gameLive->quarter;

        // We also need to update the log
        GameLog::updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_initialized',
        ], [
            'quarter'     => 1,
            'occurred_at' => '00:00:00',
        ]);

        // And update the log collection
        $this->updateLog();
    }

    public function addStartingPlayers(string $side, array $playerIds)
    {
        $log = GameLog::updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_starting_players',
        ], [
            'quarter'       => 1,
            'occurred_at'   => '00:00:00',
            'occurred_at_q' => '00:00:00',
        ]);

        // Also update the live game model
        $this->gameLive->update([$side . '_starting_players' => $playerIds]);

        // And fill the props
        foreach ($playerIds as $playerId) {
            $this->playersOnCourt->push($this->findPlayer($playerId));

            if ($side === 'home') {
                $this->homePlayersOnCourt->push($this->findPlayer($playerId));
                $this->gameLive->update(['home_players_on_court' => $this->homePlayersOnCourt->pluck('id')->toArray()]);
            } else {
                $this->awayPlayersOnCourt->push($this->findPlayer($playerId));
                $this->gameLive->update(['away_players_on_court' => $this->awayPlayersOnCourt->pluck('id')->toArray()]);
            }
        }
    }

    public function startGame()
    {
        $this->currentQuarter = 1;
        $this->gameLive->update([
            'status' => 'started',
        ]);

        // We also need to update the log
        GameLog::updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_started',
        ], [
            'quarter'       => 1,
            'occurred_at'   => '00:00:00',
            'occurred_at_q' => '00:00:00',
        ]);

        // And update the log collection
        $this->updateLog();
    }

    public function timeout(string $teamId, ?string $occurredAt = '00:00:00')
    {
        // Find the team
        $team = ($teamId === $this->homeTeam->id) ? $this->homeTeam : $this->awayTeam;
        $timeoutsLeft = ($teamId === $this->homeTeam->id) ? $this->homeTimeoutsLeft : $this->awayTimeoutsLeft;

        // We need to check if we have timeouts left
        if ($timeoutsLeft <= 0) {
            return false;
        }

        // And also update the timeouts left
        $timeoutsLeft--;
        ($teamId === $this->homeTeam->id) ? $this->homeTimeoutsLeft = $timeoutsLeft : $this->awayTimeoutsLeft = $timeoutsLeft;

        $log = $this->addLog([
            'type'        => 'timeout',
            'subtype'     => 'team_timeout',
            'team_id'     => $team->id,
            'quarter'     => $this->currentQuarter,
            'occurred_at' => $occurredAt,
        ]);

        // Now update the stats
        $this->updateLiveStats(log: $log);
    }

    public function updateGame()
    {
        // This will write the data to the DB
    }

    public function currentQuarter()
    {
        return $this->currentQuarter;
    }

    public function setQuarter($quarter)
    {
        $this->currentQuarter = $quarter;
    }

    public function nextQuarter()
    {
        // We need to rest the timeouts and fouls
        $this->homeTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->awayTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->homeFoulsLeft    = config('live.team_fouls_per_quarter');
        $this->awayFoulsLeft    = config('live.team_fouls_per_quarter');

        $this->currentQuarter++;
    }

    public function previousQuarter()
    {
        $this->currentQuarter--;
    }

    public function endGame()
    {
        $lastQuarter = 4; // Check if this is correct (could be overtime, or game suspended before)

        $this->gameLive->update([
            'status' => 'ended',
            'quarter' => $lastQuarter,
        ]);

        // We also need to update the log
        $log = GameLog::updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_ended',
        ], [
            'quarter'       => $lastQuarter,
            'occurred_at'   => '00:32:00',
            'occurred_at_q' => '00:08:00',
        ]);

        // Update the stats
        $this->updateLiveStats($log);

        // Update main game stats
        $this->updateMainStats($log);

        // And update the log collection
        $this->updateLog();
    }

    public function homeTeam()
    {
        return $this->homeTeam;
    }

    public function awayTeam()
    {
        return $this->awayTeam;
    }

    public function players()
    {
        return $this->players;
    }

    public function homePlayers()
    {
        return $this->homePlayers;
    }

    public function awayPlayers()
    {
        return $this->awayPlayers;
    }

    public function playersOnCourt()
    {
        return $this->playersOnCourt;
    }

    public function homePlayersOnCourt()
    {
        return $this->homePlayersOnCourt;
    }

    public function awayPlayersOnCourt()
    {
        return $this->awayPlayersOnCourt;
    }

    public function toArray()
    {
        $homeStartingPlayers = [];
        $awayStartingPlayers = [];
        foreach ($this->gameLive->home_starting_players as $playerId) {
            $homeStartingPlayers[] = $this->findPlayer($playerId)->toArray();
        }
        foreach ($this->gameLive->away_starting_players as $playerId) {
            $awayStartingPlayers[] = $this->findPlayer($playerId)->toArray();
        }

        $homePlayersOnCourt = [];
        $awayPlayersOnCourt = [];
        foreach ($this->gameLive->home_players_on_court as $playerId) {
            $homePlayersOnCourt[] = $this->findPlayer($playerId)->toArray();
        }
        foreach ($this->gameLive->away_players_on_court as $playerId) {
            $awayPlayersOnCourt[] = $this->findPlayer($playerId)->toArray();
        }

        // Add logos
        $homeTeam = $this->homeTeam->toArray();
        $awayTeam = $this->awayTeam->toArray();
        $homeTeam['logo'] = $this->homeTeam->logo();
        $awayTeam['logo'] = $this->awayTeam->logo();

        return [
            'status'                => $this->gameLive->status,
            'quarter'               => $this->currentQuarter(),
            'game'                  => $this->game->toArray(),
            'game_live'             => $this->gameLive->toArray(),
            'home_team'             => $homeTeam,
            'away_team'             => $awayTeam,
            'home_score'            => $this->gameLive->home_score,
            'away_score'            => $this->gameLive->away_score,
            'players'               => $this->players->toArray(),
            'home_players'          => $this->homePlayers->toArray(),
            'away_players'          => $this->awayPlayers->toArray(),
            'players_on_court'      => array_merge($homePlayersOnCourt, $awayPlayersOnCourt),
            'home_players_on_court' => $homePlayersOnCourt,
            'away_players_on_court' => $awayPlayersOnCourt,
            'home_players_on_bench' => $this->homePlayers->diff($this->homePlayersOnCourt)->toArray(),
            'away_players_on_bench' => $this->awayPlayers->diff($this->awayPlayersOnCourt)->toArray(),
            'starting_players'      => array_merge($homeStartingPlayers, $awayStartingPlayers),
            'home_starting_players' => $homeStartingPlayers,
            'away_starting_players' => $awayStartingPlayers,
            'log'                   => $this->logStream(),
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Update stats for main game, this is usually done at the end of the game
     *
     * @param  GameLog $log
     * @return void
     */
    public function updateMainStats(GameLog $log)
    {
        // $this->game->update([
        //     'home_score' => $log->home_score,
        //     'away_score' => $log->away_score,
        // ]);
    }
}
