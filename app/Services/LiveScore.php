<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameLive;
use App\Models\GameLog;
use App\Models\Team;
use Illuminate\Support\Collection;

class LiveScore
{
    use LiveScoreLog, LiveScorePlayer, LiveScoreStats;

    protected Game $game;

    protected GameLive $gameLive;

    protected ?Team $homeTeam;

    protected ?Team $awayTeam;

    protected ?Collection $players;

    protected ?Collection $homePlayers;

    protected ?Collection $awayPlayers;

    protected ?Collection $availableHomePlayers;

    protected ?Collection $availableAwayPlayers;

    protected int $currentPeriod = 1;

    protected ?Collection $startingPlayers;

    protected ?Collection $homeStartingPlayers;

    protected ?Collection $awayStartingPlayers;

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
            $this->game = Game::find($game)->with(['homeTeam', 'awayTeam', 'homeTeam.players', 'awayTeam.players', 'homeTeam.players.media', 'awayTeam.players.media'])->first();
        } else {
            $this->game = $game;
        }

        // We need to preload the teams and players to avoid N+1
        $this->homeTeam    = $this->game->homeTeam()->with(['players', 'players.media'])->first();
        $this->awayTeam    = $this->game->awayTeam()->with(['players', 'players.media'])->first();

        $this->availableHomePlayers = $this->homeTeam ? $this->homeTeam->players : null;
        $this->availableAwayPlayers = $this->awayTeam ? $this->awayTeam->players : null;

        $this->homePlayers = $this->game->homePlayers;
        $this->awayPlayers = $this->game->awayPlayers;
        $this->players     = $this->homePlayers->merge($this->awayPlayers);

        // Init starting players
        $this->startingPlayers     = new Collection();
        $this->homeStartingPlayers = new Collection();
        $this->awayStartingPlayers = new Collection();

        // Init players on court
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        // Init timeouts and fouls
        $this->homeTimeoutsLeft = config('live.team_timeouts_per_period');
        $this->awayTimeoutsLeft = config('live.team_timeouts_per_period');
        $this->homeFoulsLeft    = config('live.team_fouls_per_period');
        $this->awayFoulsLeft    = config('live.team_fouls_per_period');

        $this->initGame();
    }

    public function initGame()
    {
        // This simply creates the game live model
        $this->gameLive       = $this->game->live()->firstOrCreate([], ['period' => 1, 'home_starting_players' => [], 'away_starting_players' => [], 'home_players_on_court' => [], 'away_players_on_court' => []]);
        $this->currentPeriod  = $this->gameLive->period;

        // Setup the players
        $this->setupPlayers();

        // We also need to update the log
        GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_initialized',
        ], [
            'period'      => 1,
            'occurred_at' => '00:00:00',
        ]);

        // And update the log collection
        $this->updateLog();
    }

    function setupPlayers()
    {
        // Add players if we have any
        $this->startingPlayers     = new Collection();
        $this->homeStartingPlayers = new Collection();
        $this->awayStartingPlayers = new Collection();
        $this->playersOnCourt      = new Collection();
        $this->homePlayersOnCourt  = new Collection();
        $this->awayPlayersOnCourt  = new Collection();
        if ($this->gameLive->home_starting_players) {
            foreach ($this->gameLive->home_starting_players as $playerId) {
                $this->startingPlayers->push($this->findPlayer($playerId));
                $this->homeStartingPlayers->push($this->findPlayer($playerId));
            }
        }
        if ($this->gameLive->away_starting_players) {
            foreach ($this->gameLive->away_starting_players as $playerId) {
                $this->startingPlayers->push($this->findPlayer($playerId));
                $this->awayStartingPlayers->push($this->findPlayer($playerId));
            }
        }
        if ($this->gameLive->home_players_on_court) {
            foreach ($this->gameLive->home_players_on_court as $playerId) {
                $this->playersOnCourt->push($this->findPlayer($playerId));
                $this->homePlayersOnCourt->push($this->findPlayer($playerId));
            }
        }
        if ($this->gameLive->away_players_on_court) {
            foreach ($this->gameLive->away_players_on_court as $playerId) {
                $this->playersOnCourt->push($this->findPlayer($playerId));
                $this->awayPlayersOnCourt->push($this->findPlayer($playerId));
            }
        }
    }

    public function addStartingPlayers(array $homePlayerIds, array $awayPlayerIds)
    {
        $log = GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_starting_players',
        ], [
            'period'        => 1,
            'occurred_at'   => '00:00:00',
            'occurred_at_p' => '00:00:00',
        ]);

        // All starting players
        $playerIds = array_merge($homePlayerIds, $awayPlayerIds);

        // Also update the live game model
        $this->gameLive->update(['home_starting_players' => $homePlayerIds, 'away_starting_players' => $awayPlayerIds]);

        // Reset the players
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        foreach ($homePlayerIds as $playerId) {
            $this->homePlayersOnCourt->push($this->findPlayer($playerId));
        }
        $this->gameLive->update(['home_players_on_court' => $this->homePlayersOnCourt->pluck('id')->toArray()]);
        foreach ($awayPlayerIds as $playerId) {
            $this->awayPlayersOnCourt->push($this->findPlayer($playerId));
        }
        $this->gameLive->update(['away_players_on_court' => $this->awayPlayersOnCourt->pluck('id')->toArray()]);

        // And fill the props
        $this->playersOnCourt = $this->homePlayersOnCourt->merge($this->awayPlayersOnCourt);
    }

    public function startGame($writeToLog = true)
    {
        $this->currentPeriod = 1;
        $this->gameLive->update([
            'status' => 'in_progress',
        ]);
        $this->game->update([
            'status' => 'in_progress',
        ]);

        // We also need to update the log
        if ($writeToLog) {
            GameLog::query()->updateOrCreate([
                'game_id'      => $this->game->id,
                'game_live_id' => $this->gameLive->id,
                'type'         => 'game_started',
            ], [
                'period'        => 1,
                'occurred_at'   => '00:00:00',
                'occurred_at_p' => '00:00:00',
            ]);
        }

        // Setup the players
        $this->setupPlayers();

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
            'period'      => $this->currentPeriod,
            'occurred_at' => $occurredAt,
        ]);

        // Now update the stats
        $this->updateLiveStats(log: $log);
    }

    public function updateGame()
    {
        // This will write the data to the DB
    }

    public function currentPeriod()
    {
        return $this->currentPeriod;
    }

    public function setPeriod($period)
    {
        $this->currentPeriod = $period;
    }

    public function nextPeriod()
    {
        // We need to reset the timeouts and fouls
        $this->homeTimeoutsLeft = config('live.team_timeouts_per_period');
        $this->awayTimeoutsLeft = config('live.team_timeouts_per_period');
        $this->homeFoulsLeft    = config('live.team_fouls_per_period');
        $this->awayFoulsLeft    = config('live.team_fouls_per_period');

        $this->currentPeriod++;

        // Update the game live model
        $this->gameLive->update([
            'period' => $this->currentPeriod,
        ]);

        // And add a log that the period has started
        $log = $this->addLog([
            'type'        => 'period_started',
            'period'      => $this->currentPeriod,
            'occurred_at' => '00:00:00',
        ]);

        // Now update the stats
        $this->updateLiveStats(log: $log);
    }

    public function previousPeriod()
    {
        $this->currentPeriod--;
    }

    public function endGame()
    {
        // $lastPeriod = 4; // Check if this is correct (could be overtime, or game suspended before)

        $this->gameLive->update([
            'status' => 'ended',
            // 'period' => $lastPeriod,
        ]);

        // We also need to update the log
        $log = GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_ended',
        ], [
            'period'        => $this->gameLive->period,
            'occurred_at'   => '00:32:00',
            'occurred_at_p' => '00:08:00',
        ]);

        // Update the stats
        $this->updateLiveStats($log);

        // Update main game stats
        $this->updateMainStats($log);

        // And update the log collection
        $this->updateLog();
    }

    public function gameLive(): GameLive
    {
        return $this->gameLive;
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
        // Add logos
        $homeTeam = $this->homeTeam->toArray();
        $awayTeam = $this->awayTeam->toArray();
        $homeTeam['logo'] = $this->homeTeam->logo();
        $awayTeam['logo'] = $this->awayTeam->logo();

        // We also need to add player and game stats
        $this->addPlayerStats();

        return [
            'status'                => $this->gameLive->status,
            'period'                => $this->currentPeriod(),
            'game'                  => $this->game->toArray(),
            'game_live'             => $this->gameLive->toArray(),
            'home_team'             => $homeTeam,
            'away_team'             => $awayTeam,
            'home_score'            => $this->gameLive->home_score,
            'away_score'            => $this->gameLive->away_score,
            'players'               => $this->players->toArray(),
            'home_players'          => $this->homePlayers ? $this->homePlayers->toArray() : null,
            'away_players'          => $this->awayPlayers ? $this->awayPlayers->toArray() : null,
            'players_on_court'      => array_merge($this->homePlayersOnCourt->toArray(), $this->awayPlayersOnCourt->toArray()),
            'home_players_on_court' => $this->homePlayersOnCourt->toArray(),
            'away_players_on_court' => $this->awayPlayersOnCourt->toArray(),
            'home_players_on_bench' => $this->homePlayers->diff($this->homePlayersOnCourt)->toArray(),
            'away_players_on_bench' => $this->awayPlayers->diff($this->awayPlayersOnCourt)->toArray(),
            'starting_players'      => array_merge($this->homeStartingPlayers->toArray(), $this->awayStartingPlayers->toArray()),
            'home_starting_players' => $this->homeStartingPlayers->toArray(),
            'away_starting_players' => $this->awayStartingPlayers->toArray(),
            'log'                   => $this->logStream(),
        ];
    }

    /**
     * Optimized data for frontend JSON
     *
     * @return array
     */
    public function toData($addTeamStats = true, $addPlayerStats = true): array
    {
        // We also need to add player and team stats
        if ($addPlayerStats) $this->addPlayerStats();
        if ($addTeamStats)   $this->addTeamStats();

        // Prepare the data
        $data = [
            'game'       => $this->game->toArray(),
            'gameLive'   => $this->gameLive->toArray(),
            'log'        => $this->logStream(),
        ];

        // Add more data
        $data['gameLive']['title'] = $data['game']['title'];

        // We need to adjust some data
        foreach (['home_starting_players', 'away_starting_players', 'home_players_on_court', 'away_players_on_court'] as $type) {
            if (isset($data['gameLive'][$type]) && $data['gameLive'][$type]) {
                $players = [];
                foreach ($data['gameLive'][$type] as $key => $playerId) {
                    $player = $this->findPlayer($playerId);
                    $players[$key] = $player->toArray();
                }
                $data['game'][$type] = $players;
                $data['gameLive'][$type] = $players;
            } else {
                $data['game'][$type] = [];
                $data['gameLive'][$type] = [];
            }
        }

        // Add some team data
        $data['game']['available_home_players'] = $data['gameLive']['available_home_players'] = $this->availableHomePlayers?->toArray();
        $data['game']['available_away_players'] = $data['gameLive']['available_away_players'] = $this->availableAwayPlayers?->toArray();
        $data['game']['home_players']           = $data['gameLive']['home_players']           = $this->homePlayers?->toArray();
        $data['game']['away_players']           = $data['gameLive']['away_players']           = $this->awayPlayers?->toArray();
        $data['game']['home_team']              = $data['gameLive']['home_team']              = $this->homeTeam?->toArray();
        $data['game']['away_team']              = $data['gameLive']['away_team']              = $this->awayTeam?->toArray();
        $data['game']['home_team']['logo']      = $data['gameLive']['home_team']['logo']      = $this->homeTeam?->logo();
        $data['game']['away_team']['logo']      = $data['gameLive']['away_team']['logo']      = $this->awayTeam?->logo();
        $data['game']['home_players_on_bench']  = $data['gameLive']['home_players_on_bench']  = $this->homePlayers?->diff($this->homePlayersOnCourt)->toArray();
        $data['game']['away_players_on_bench']  = $data['gameLive']['away_players_on_bench']  = $this->awayPlayers?->diff($this->awayPlayersOnCourt)->toArray();
        unset($data['game']['home_team']['players']);
        unset($data['game']['away_team']['players']);

        return $data;
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
        $this->game->update([
            'home_score' => $log->home_score,
            'away_score' => $log->away_score,
        ]);
    }
}
