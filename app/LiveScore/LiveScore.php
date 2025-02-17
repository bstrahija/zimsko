<?php

namespace App\LiveScore;

use App\LiveScore\Traits\LogData;
use App\LiveScore\Traits\StatsData;
use App\Models\Game;
use App\Models\GameLog;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

class LiveScore
{
    use StatsData, LogData;

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

    public ?Collection $playersOnCourt;

    public ?Collection $homePlayersOnCourt;

    public ?Collection $awayPlayersOnCourt;

    protected int $homeTimeoutsLeft;

    protected int $awayTimeoutsLeft;

    protected int $homeFoulsLeft;

    protected int $awayFoulsLeft;

    protected static ?LiveScore $live = null;

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

    /**
     * Add game stats from the request
     *
     * @param  Request $request
     * @return void
     */
    public function addStatFromRequest(Request $request): void
    {
        $action = $request->input('action');
        $data   = static::formatRequestData($request);
        dump($data);

        if ($action && $data) {
            if ($action === 'score')            app(Actions\AddScore::class)->handle(gameId: $this->game->id, playerId: $data->player_id, amount: $data->amount, otherPlayerId: $data->player_2_id);
            elseif ($action === 'miss')         app(Actions\AddMiss::class)->handle(gameId: $this->game->id, playerId: $data->player_id, amount: $data->amount);
            elseif ($action === 'assist')       app(Actions\AddAssist::class)->handle(gameId: $this->game->id, playerId: $data->player_id);
            elseif ($action === 'rebound')      app(Actions\AddRebound::class)->handle(gameId: $this->game->id, playerId: $data->player_id, type: $data->subtype);
            elseif ($action === 'steal')        app(Actions\AddSteal::class)->handle(gameId: $this->game->id, playerId: $data->player_id, otherPlayerId: $data->player_2_id);
            elseif ($action === 'block')        app(Actions\AddBlock::class)->handle(gameId: $this->game->id, playerId: $data->player_id, otherPlayerId: $data->player_2_id);
            elseif ($action === 'turnover')     app(Actions\AddTurnover::class)->handle(gameId: $this->game->id, playerId: $data->player_id);
            elseif ($action === 'foul')         app(Actions\AddFoul::class)->handle(gameId: $this->game->id, teamId: $data->team_id, playerId: $data->player_id, type: $data->subtype, otherPlayerId: $data->player_2_id);
            elseif ($action === 'substitution') app(Actions\Substitution::class)->handle(gameId: $this->game->id, playersIn: $data->players_in, playersOut: $data->players_out);
            elseif ($action === 'timeout')      app(Actions\Timeout::class)->handle(gameId: $this->game->id, teamId: $data->team_id);
        }
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
        // TODO: Clean this up
        $this->refreshLog();
    }

    /**
     * Load the players for the game
     *
     * @return void
     */
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

        // Init starting players
        $this->startingPlayers     = new Collection();
        $this->homeStartingPlayers = new Collection();
        $this->awayStartingPlayers = new Collection();

        // Init players on court
        $this->playersOnCourt     = new Collection();
        $this->homePlayersOnCourt = new Collection();
        $this->awayPlayersOnCourt = new Collection();

        // After loading the player we remove the relations for better performance
        $this->game->setRelations(['referees' => $this->game->referees]);
    }

    /**
     * Setup the players and add them to the proper collections
     *
     * @return void
     */
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

    /**
     * Save stating players to the DB (IDs)
     *
     * @param array $homePlayerIds
     * @param array $awayPlayerIds
     * @return void
     */
    public function addStartingPlayers(array $homePlayerIds, array $awayPlayerIds)
    {
        if (! $this->game->status !== 'in_progress') {
            GameLog::query()->updateOrCreate([
                'game_id'      => $this->game->id,
                'type'         => 'game_starting_players',
            ], [
                'period'        => 1,
                'occurred_at'   => '00:00:00',
                'occurred_at_p' => '00:00:00',
            ]);
        }

        // Also update the live game model
        $this->game->update(['home_starting_players' => $homePlayerIds, 'away_starting_players' => $awayPlayerIds]);

        if (! $this->game->status === 'in_progress') {
            $this->game->update(['home_players_on_court' => $homePlayerIds, 'away_players_on_court' => $awayPlayerIds]);
        }

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

    public function updatePlayersOnCourt(array $homePlayerIds, array $awayPlayerIds)
    {
        $this->game->update(['home_players_on_court' => $homePlayerIds, 'away_players_on_court' => $awayPlayerIds]);

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

    /**
     * Start the game, set status and setup the players to start
     *
     * @return void
     */
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
        $this->refreshLog();
    }

    /**
     * Load game model with all required relations to avoid n+1
     *
     * @param  Game|int $game
     * @return Game
     */
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

    /**
     * Find player by ID
     *
     * @param int $playerId
     * @return null|Player
     */
    public function findPlayer(int $playerId): ?Player
    {
        return $this->players->where('id', $playerId)->first();
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

    public function game(): Game
    {
        return $this->game;
    }

    public function homePlayers(): Collection
    {
        return $this->homePlayers;
    }

    public function awayPlayers(): Collection
    {
        return $this->awayPlayers;
    }

    /**
     * Simply return the current period
     *
     * @return int
     */
    public function currentPeriod(): int
    {
        return $this->currentPeriod;
    }

    /**
     * Array representation of all live score data for the game
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
     * Optimizes the data for Inertia
     *
     * @return array
     */
    public function toOptimizedData(): array
    {
        return $this->optimizeData($this->toData());
    }

    /**
     * Optimize the data for Inertia
     *
     * @param  array $data
     * @return array
     */
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

    public static function formatRequestData(Request $request): Fluent
    {
        // Default type and amount
        $data = [
            'type'   => 'player_' . $request->input('action'),
            'amount' => 1,
        ];

        // Get player and team data
        if ($request->input('selectedPlayer')) {
            $data['player_id'] = $request->input('selectedPlayer')['id'];
            $data['team_id'] = $request->input('teamId');
        }

        // Handle score and miss
        if ($request->input('action') === 'score' || $request->input('action') === 'miss') {
            $data['amount']  = $request->input('type');
            $data['subtype'] = $request->input('type') . 'pt';
        }

        // Handle substitution
        if ($request->input('action') === 'substitution') {
            unset($data['amount']);
            $data['type']        = 'substitution';
            $playersInIds        = array_column($request->input('selectedPlayersIn'), 'id');
            $playersOutIds       = array_column($request->input('selectedPlayersOut'), 'id');
            $data['players_in']  = $playersInIds;
            $data['players_out'] = $playersOutIds;
        }

        // Handle timeouts
        if ($request->input('action') === 'timeout') {
            $data['action']  = 'timeout';
            $data['team_id'] = $request->input('team_id');
        }

        // Handle others
        if ($request->input('action') === 'assist')   $data['subtype'] = 'ast';
        if ($request->input('action') === 'assist')   $data['subtype'] = 'ast';
        if ($request->input('action') === 'rebound')  $data['subtype'] = $request->input('type');
        if ($request->input('action') === 'steal')    $data['subtype'] = 'stl';
        if ($request->input('action') === 'turnover') $data['subtype'] = 'to';
        if ($request->input('action') === 'foul')     $data['subtype'] = 'pf';
        if ($request->input('action') === 'foul' && $request->input('type') === 'tf') $data['subtype'] = 'tf';
        if ($request->input('action') === 'foul' && $request->input('type') === 'ff') $data['subtype'] = 'ff';

        // Handle team technical foul
        if ($request->input('action') === 'foul' && $request->input('type') === 'tf' && $request->input('teamId') && ! $request->input('selectedPlayer')) {
            $data['team_id'] = $request->input('teamId');
            $data['type'] = 'team_technical_foul';
            $data['subtype'] = 'tf';
        }

        return fluent($data);
    }

    /**
     * Get all scores from the log and updates them
     *
     * @return void
     */
    public function updateLogScore()
    {
        // TODO: maybe we don't need this method
    }

    public function updateGameDataFromLog()
    {
        // Make sure we have the latest log entr4ies
        $this->refreshLog();

        // Update with last log
        $this->game->update([
            'home_score' => $this->log->sortByDesc('id')->first()?->home_score ?: 0,
            'away_score' => $this->log->sortByDesc('id')->first()?->away_score ?: 0,
        ]);

        // Also update periods
        $periodScores = [];
        foreach (['home', 'away'] as $side) {
            foreach (range(1, 10) as $period) {
                $periodScores[$side . '_score_p' . $period] = $this->log->where('type', 'player_score')->where('team_side', $side)->where('period', $period)->sum('amount') ?: 0;
            }
        }
        $this->game->update($periodScores);
    }

    /**
     * Helper for building new instances
     *
     * @param  Game $game
     * @return LiveScore
     */
    public static function build(Game $game): LiveScore
    {
        if (! self::$live) {
            self::$live = new LiveScore($game);
        }

        return self::$live;
    }
}
