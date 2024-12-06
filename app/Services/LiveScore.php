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
            $this->game = Game::find($game)->with(['homeTeam', 'awayTeam', 'homeTeam.players', 'awayTeam.players']);
        } else {
            $this->game = $game;
        }

        // We need to preload the teams and players to avoid N+1
        $this->homeTeam    = $this->game->homeTeam()->with(['players'])->first();
        $this->awayTeam    = $this->game->awayTeam()->with(['players'])->first();
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
        $this->homeTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->awayTimeoutsLeft = config('live.team_timeouts_per_quarter');
        $this->homeFoulsLeft    = config('live.team_fouls_per_quarter');
        $this->awayFoulsLeft    = config('live.team_fouls_per_quarter');

        $this->initGame();
    }

    public function initGame()
    {
        // This simply creates the game live model
        $this->gameLive       = $this->game->live()->firstOrCreate([], ['quarter' => 1]);
        $this->currentQuarter = $this->gameLive->quarter;

        // Setup the players
        $this->setupPlayers();

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
        $log = GameLog::updateOrCreate([
            'game_id'      => $this->game->id,
            'game_live_id' => $this->gameLive->id,
            'type'         => 'game_starting_players',
        ], [
            'quarter'       => 1,
            'occurred_at'   => '00:00:00',
            'occurred_at_q' => '00:00:00',
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

        // Setup the players
        $this->setupPlayers();
        $this->setupPlayers();
        $this->setupPlayers();
        $this->setupPlayers();
        $this->setupPlayers();
        $this->setupPlayers();
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

        // And add a log that the quarter has started
        $log = $this->addLog([
            'type'        => 'quarter_started',
            'quarter'     => $this->currentQuarter,
            'occurred_at' => '00:00:00',
        ]);

        // Now update the stats
        $this->updateLiveStats(log: $log);
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

    public function addPlayerStats()
    {
        // dump($this->log);
        foreach ($this->players as $player) {
            // First the scores
            $scores = $this->log->where('player_id', $player->id)->filter(static function ($item, $key) {
                return $item->type === 'player_score' || $item->type === 'player_score_with_assist';
            });
            $misses = $this->log->where('player_id', $player->id)->filter(static function ($item, $key) {
                return $item->type === 'player_miss';
            });
            $player->setStats('points', $scores ? $scores->sum('amount') : 0);
            $player->setStats('misses', $misses ? $misses->sum('amount') : 0);

            $fouls = $this->log->where('player_id', $player->id)->filter(static function ($item, $key) {
                return $item->type === 'player_foul';
            });
            $player->setStats('fouls', $fouls ? $fouls->sum('amount') : 0);

            // $fouls = $this->log->where('type', 'player_foul');
            // $player->setStats('fouls', $fouls->sum('amount'));
        }
        // die();
    }

    public function addTeamStats()
    {
        foreach ([$this->homeTeam, $this->awayTeam] as $team) {
            $side = $team->id === $this->homeTeam->id ? 'home' : 'away';
            $team->setStats('score', $this->gameLive->{$side . '_score'});

            // Misses
            $misses = $this->log->where('team_id', $team->id)->filter(static function ($item, $key) {
                return $item->type === 'player_miss';
            });
            $team->setStats('misses', $misses->sum('amount'));

            // Fouls
            $fouls = $this->log->where('team_id', $team->id)->filter(static function ($item, $key) {
                return $item->type === 'player_foul';
            });
            $team->setStats('fouls', $fouls->sum('amount'));
            $periodFouls = $this->log->where('team_id', $team->id)->where('quarter', $this->currentQuarter)->filter(static function ($item, $key) {
                return $item->type === 'player_foul';
            });
            $team->setStats('period_fouls', $periodFouls->sum('amount'));

            // Timeouts
            $timeouts = $this->log->where('team_id', $team->id)->filter(static function ($item, $key) {
                return $item->type === 'timeout';
            });
            $team->setStats('timeouts', $timeouts->sum('amount'));
            $periodTimeouts = $this->log->where('team_id', $team->id)->where('quarter', $this->currentQuarter)->filter(static function ($item, $key) {
                return $item->type === 'timeout';
            });
            $team->setStats('period_timeouts', $periodTimeouts->sum('amount'));
        }
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
    public function toData(): array
    {
        // We also need to add player and team stats
        $this->addPlayerStats();
        $this->addTeamStats();

        // Prepare the data
        $data = [
            'game' => $this->game->toArray(),
            'live' => $this->gameLive->toArray(),
            'log'  => $this->logStream(),
        ];

        // We need to adjust some data
        foreach (['home_starting_players', 'away_starting_players', 'home_players_on_court', 'away_players_on_court'] as $type) {
            if ($data['live'][$type]) {
                $players = [];
                foreach ($data['live'][$type] as $key => $playerId) {
                    $player = $this->findPlayer($playerId);
                    $players[$key] = $player->toArray();
                }
                $data['live'][$type] = $players;
            }
        }

        // Add some team data
        $data['live']['home_players']          = $this->homePlayers->toArray();
        $data['live']['away_players']          = $this->awayPlayers->toArray();
        $data['live']['home_team']             = $this->homeTeam->toArray();
        $data['live']['away_team']             = $this->awayTeam->toArray();
        $data['game']['home_team']['logo']     = $this->homeTeam->logo();
        $data['game']['away_team']['logo']     = $this->awayTeam->logo();
        $data['live']['home_team']['logo']     = $data['game']['home_team']['logo'];
        $data['live']['away_team']['logo']     = $data['game']['away_team']['logo'];
        $data['live']['home_players_on_bench'] = $this->homePlayers->diff($this->homePlayersOnCourt)->toArray();
        $data['live']['away_players_on_bench'] = $this->awayPlayers->diff($this->awayPlayersOnCourt)->toArray();
        unset($data['live']['home_team']['players']);
        unset($data['live']['away_team']['players']);

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
        // $this->game->update([
        //     'home_score' => $log->home_score,
        //     'away_score' => $log->away_score,
        // ]);
    }
}
