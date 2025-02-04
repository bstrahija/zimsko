<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\Team;
use Illuminate\Support\Collection;

class LiveScore
{
    use LiveScoreLog, LiveScorePlayer, LiveScoreStats;

    protected Game $game;

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

    public function __construct(Game|int $game, $loadPlayers = true)
    {
        // First find the game model
        $game = $this->loadGame($game);

        // We need to preload the teams and players to avoid N+1
        $this->homeTeam    = $this->game->homeTeam;
        $this->awayTeam    = $this->game->awayTeam;

        if ($loadPlayers) {
            $this->loadPlayers();
        }

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
        $this->currentPeriod  = $this->game->period;

        // Setup the players
        $this->setupPlayers();

        // We also need to update the log
        GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'type'         => 'game_initialized',
        ], [
            'period'      => 1,
            'occurred_at' => '00:00:00',
        ]);

        // And update the log collection
        $this->updateLog();
    }

    public function loadPlayers()
    {
        // Initialize players
        $this->players = new Collection();

        // First get all available players
        $this->availableHomePlayers = $this->homeTeam ? $this->homeTeam->activePlayers : new Collection();
        $this->availableAwayPlayers = $this->awayTeam ? $this->awayTeam->activePlayers : new Collection();

        // Then we get players selected for this game
        $playerIds = $this->game->players->pluck('id');

        // Add selected players to main array
        foreach ($playerIds as $playerId) {
            if ($found = $this->availableHomePlayers->where('id', $playerId)->first()) {
                $this->players->push($found);
            } elseif ($found = $this->availableAwayPlayers->where('id', $playerId)->first()) {
                $this->players->push($found);
            }
        }

        // Add players to required collections
        $this->getPlayersBySide('home');
        $this->getPlayersBySide('away');

        // // Init starting players
        $this->startingPlayers     = new Collection();
        $this->homeStartingPlayers = new Collection();
        $this->awayStartingPlayers = new Collection();

        // // Init players on court
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        // After loading the player we remove the relations for better performance
        $this->game->setRelations(['referees' => $this->game->referees]);
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
        if ($this->game->home_starting_players) {
            foreach ($this->game->home_starting_players as $playerId) {
                $this->startingPlayers->push($this->findPlayer($playerId));
                $this->homeStartingPlayers->push($this->findPlayer($playerId));
            }
        }
        if ($this->game->away_starting_players) {
            foreach ($this->game->away_starting_players as $playerId) {
                $this->startingPlayers->push($this->findPlayer($playerId));
                $this->awayStartingPlayers->push($this->findPlayer($playerId));
            }
        }
        if ($this->game->home_players_on_court) {
            foreach ($this->game->home_players_on_court as $playerId) {
                $this->playersOnCourt->push($this->findPlayer($playerId));
                $this->homePlayersOnCourt->push($this->findPlayer($playerId));
            }
        }
        if ($this->game->away_players_on_court) {
            foreach ($this->game->away_players_on_court as $playerId) {
                $this->playersOnCourt->push($this->findPlayer($playerId));
                $this->awayPlayersOnCourt->push($this->findPlayer($playerId));
            }
        }
    }

    public function addStartingPlayers(array $homePlayerIds, array $awayPlayerIds)
    {
        GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'type'         => 'game_starting_players',
        ], [
            'period'        => 1,
            'occurred_at'   => '00:00:00',
            'occurred_at_p' => '00:00:00',
        ]);

        // Also update the live game model
        $this->game->update(['home_starting_players' => $homePlayerIds, 'away_starting_players' => $awayPlayerIds]);

        // Reset the players
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        foreach ($homePlayerIds as $playerId) {
            $this->homePlayersOnCourt->push($this->findPlayer($playerId));
        }
        $this->game->update(['home_players_on_court' => $this->homePlayersOnCourt->pluck('id')->toArray()]);
        foreach ($awayPlayerIds as $playerId) {
            $this->awayPlayersOnCourt->push($this->findPlayer($playerId));
        }
        $this->game->update(['away_players_on_court' => $this->awayPlayersOnCourt->pluck('id')->toArray()]);

        // And fill the props
        $this->playersOnCourt = $this->homePlayersOnCourt->merge($this->awayPlayersOnCourt);
    }

    public function startGame($writeToLog = true)
    {
        $this->currentPeriod = 1;
        $this->game->update(['status' => 'in_progress']);

        // We also need to update the log
        if ($writeToLog) {
            GameLog::query()->updateOrCreate([
                'game_id'      => $this->game->id,
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
        $team         = ($teamId === $this->homeTeam->id) ? $this->homeTeam : $this->awayTeam;
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
        $this->game->update([
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

        $this->game->update(['status' => 'completed']);

        // We also need to update the log
        $log = GameLog::query()->updateOrCreate([
            'game_id'      => $this->game->id,
            'type'         => 'game_ended',
        ], [
            'period'        => $this->game->period,
            'occurred_at'   => '00:32:00',
            'occurred_at_p' => '00:08:00',
        ]);

        // Update the stats
        $this->updateLiveStats($log);

        // Also update all player stats
        foreach ($this->game->players as $player) {
            $this->updatePlayerLiveStats($player);
        }

        // Update main game stats
        $this->updateMainStats($log);

        // And update the log collection
        $this->updateLog();
    }

    public function resetGame()
    {
        // Clear the log
        GameLog::where('game_id', $this->game->id)->delete();

        $data = [
            'status'                => 'scheduled',
            'period'                => 1,
            'home_starting_players' => [],
            'home_players_on_court' => [],
            'away_starting_players' => [],
            'away_players_on_court' => [],
        ];

        // Reset stats
        foreach (config('stats.columns') as $column) {
            foreach (['home', 'away'] as $side) {
                $data[$side . '_' . $column['id']] = 0;
            }
        }

        $this->game->update($data);
    }

    public function game(): Game
    {
        return $this->game;
    }

    public function log(): Collection
    {
        return $this->log;
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

    /**
     * Optimized data for frontend JSON
     *
     * @return array
     */
    public function toData($addTeamStats = true, $addPlayerStats = true): array
    {
        $data = [];

        // We also need to add player and team stats
        if ($addPlayerStats) $this->addPlayerStats();
        if ($addTeamStats)   $this->addTeamStats();

        // Prepare the data (optimize the queries)
        $data = [
            'game' => $this->game->toArray(),
            'log'  => $this->logStream(),
        ];

        // Add number and position
        $allPlayers = collect([]);
        foreach ($this->players as &$player) {
            $playerData = $player->toArray();

            $playerData['number']   = $playerData['pivot']['number'];
            $playerData['position'] = $playerData['pivot']['position'];

            $allPlayers->push($playerData);
        }

        // We need to adjust some data
        foreach (['home_starting_players', 'away_starting_players', 'home_players_on_court', 'away_players_on_court'] as $type) {
            if (isset($data['game'][$type]) && $data['game'][$type]) {
                $players = [];
                foreach ($data['game'][$type] as $key => $playerId) {
                    $player = $allPlayers->where('id', $playerId)->first();

                    if ($player) {
                        // Add number and position
                        $player['number']   = $player['pivot']['number'];
                        $player['position'] = $player['pivot']['position'];

                        $players[] = $player;
                    }
                }
                $data['game'][$type] = $players;
            } else {
                $data['game'][$type] = [];
            }
        }

        // Add some team data
        $data['game']['available_home_players'] = $this->availableHomePlayers?->toArray();
        $data['game']['available_away_players'] = $this->availableAwayPlayers?->toArray();
        $data['game']['home_players']           = $this->homePlayers?->toArray();
        $data['game']['away_players']           = $this->awayPlayers?->toArray();
        $data['game']['home_team']              = $this->homeTeam?->toArray();
        $data['game']['away_team']              = $this->awayTeam?->toArray();
        $data['game']['home_team']['logo']      = $this->homeTeam?->logo();
        $data['game']['away_team']['logo']      = $this->awayTeam?->logo();
        $data['game']['home_players_on_bench']  = $this->homePlayers?->diff($this->homePlayersOnCourt)->values()->toArray();
        $data['game']['away_players_on_bench']  = $this->awayPlayers?->diff($this->awayPlayersOnCourt)->values()->toArray();
        unset($data['game']['home_team']['players']);
        unset($data['game']['away_team']['players']);

        // We move the stats to a separate array
        $data['game']['player_stats'] = [];
        foreach ([$data['game']['home_players'], $data['game']['away_players']] as $players) {
            foreach ($players as $player) {
                $data['game']['player_stats']['player__' . $player['id']] = $player['stats'];
            }
        }

        return $data;
    }

    /**
     * Optimized data
     *
     * @return array
     */
    public function toOptimizedData(): array
    {
        return $this->optimizeData($this->toData());
    }

    public function optimizeData(array $data): array
    {
        unset($data['game']['created_at'], $data['game']['updated_at'], $data['game']['deleted_at']);

        // Remove unnecessary data
        foreach (
            [
                'home_players',
                'away_players',
                'home_starting_players',
                'away_starting_players',
                'home_players_on_court',
                'away_players_on_court',
                'available_home_players',
                'available_away_players',
                'home_players_on_bench',
                'away_players_on_bench'
            ] as $type
        ) {
            foreach ($data['game'][$type] as $key => $player) {
                unset(
                    $data['game'][$type][$key]['created_at'],
                    $data['game'][$type][$key]['updated_at'],
                    $data['game'][$type][$key]['deleted_at'],
                    $data['game'][$type][$key]['data'],
                    $data['game'][$type][$key]['stats'],
                    $data['game'][$type][$key]['nickname'],
                    $data['game'][$type][$key]['body'],
                    $data['game'][$type][$key]['birthday'],
                    $data['game'][$type][$key]['media'],
                    $data['game'][$type][$key]['external_id'],
                    $data['game'][$type][$key]['status'],
                );
            }
        }


        return $data;
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

    public function loadGame(Game|int $game): Game
    {
        $requiredRelations = [
            'homeTeam',
            'awayTeam',
            'homeTeam.media',
            'awayTeam.media',
            'homeTeam.activePlayers',
            'homeTeam.activePlayers.media',
            'awayTeam.activePlayers',
            'awayTeam.activePlayers.media',
            'referees',
            'referees.media',
        ];

        // Load if needed
        if (is_int($game)) {
            $this->game = Game::find($game)->with($requiredRelations)->first();
        } else {
            $this->game = Game::where('id', $game->id)->with($requiredRelations)->first();
        }

        return $this->game;
    }
}
