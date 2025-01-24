<?php

namespace App\Http\Controllers;

use App\Events\LiveScoreUpdated;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Game;
use App\Models\GameLog;
use App\Models\GamePlayer;
use App\Models\Official;
use App\Models\Team;
use App\Services\LiveScore;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class LiveController extends Controller
{
    protected ?LiveScore $live = null;

    /**
     * List of live games
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $currentEvent = Event::current();
        $lastEvent    = Event::last();
        $keyword      = trim($request->get('query'));
        $eventId      = $request->get('event') ?: ($currentEvent ? $currentEvent->id : ($lastEvent ? $lastEvent->id : null));
        $team         = $request->get('team');
        $events       = Event::orderBy('scheduled_at', 'desc')->get();
        $teams        = Team::orderBy('title', 'desc')->get();

        // Start the query
        $query = Game::orderBy('scheduled_at', 'desc')->where('event_id', $eventId)->whereNot('status', 'tmp')->with(['event', 'homeTeam', 'awayTeam']);

        // Add keyword
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%');
            });
        }

        // Add team
        if ($team) {
            $query->where(function ($q) use ($team) {
                $q->where('home_team_id', $team)
                    ->orWhere('away_team_id', $team)
                ;
            });
        }

        // And get results
        $games  = $query->limit(50)->get();

        return Inertia::render('Index', [
            'games'   => $games,
            'events'  => $events,
            'eventId' => $eventId ? (int) $eventId : null,
            'teams'   => $teams,
        ]);
    }

    /**
     * Create new game
     *
     * @param  Request  $request
     * @return Response
     */
    public function create()
    {
        $currentEvent = Event::current();
        $lastEvent    = Event::last();
        $eventId      = $currentEvent ? $currentEvent->id : ($lastEvent ? $lastEvent->id : null);
        $event        = Event::find($eventId);
        $game = Game::query()->create([
            'status'   => 'tmp',
            'title'    => 'Nova utakmica',
            'event_id' => $eventId,
        ]);

        // Redirect to the game
        return redirect()->route('live.details', ['game' => $game]);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return to_route('live', ['event' => $game->event_id]);
    }

    /**
     * Edit game details (title, teams, event, status etc.)
     *
     * @param  Game $game
     * @return Response
     */
    public function details(Game $game)
    {
        // Load referees
        $game = $game->load('referees');

        // We need to convert all the data to an array
        $data = $this->live($game)->toData();

        // Add some edditional data
        $data['currentEvent'] = Event::current() ?: Event::latest();
        $data['events']       = Event::active()->with(['teams', 'rounds'])->orderBy('scheduled_at', 'desc')->get()->toArray();
        $data['referees']     = Official::active()->referees()->orderBy('first_name')->get()->toArray();

        return Inertia::render('Details', $data);
    }

    /**
     * Store game details
     *
     * @param Game $game
     * @param Request $request
     */
    public function detailsStore(Game $game, Request $request)
    {
        // Basic data
        $game->homeTeam()->associate($request->input('homeTeamId'));
        $game->awayTeam()->associate($request->input('awayTeamId'));
        $game->update([
            'event_id'     => $request->input('eventId'),
            'round_id'     => $request->input('roundId'),
            'title'        => $request->input('title'),
            'scheduled_at' => $request->input('scheduledAt'),
            'slug'         => Str::slug($request->input('title')),
            'status'       => $game->status !== 'in_progress' ? 'scheduled' : $game->status,
        ]);
        $game->regenerateSlug();

        // Also do referees
        $game->referees()->detach();
        if ($request->input('refereeId1')) $game->referees()->attach($request->input('refereeId1'));
        if ($request->input('refereeId2')) $game->referees()->attach($request->input('refereeId2'));

        return to_route('live.players', $game->id);
    }

    /**
     * Edit players  for teams, set starting players
     *
     * @param  Game $game
     * @return Response
     */
    public function players(Game $game): Response
    {
        // We need to convert all the data to an array
        $data = $this->live($game)->toData();

        return Inertia::render('Players', $data);
    }

    /**
     * Store game players
     *
     * @param Game $game
     * @param Request $request
     */
    public function playersStore(Game $game, Request $request)
    {
        $homePlayers   = $request->input('home_players');
        $homePlayerIds = collect($homePlayers)->pluck('id')->toArray();
        $awayPlayers   = $request->input('away_players');
        $awayPlayerIds = collect($awayPlayers)->pluck('id')->toArray();
        $allPlayerIds  = array_merge($homePlayerIds, $awayPlayerIds);
        $liveHomePlayers = new Collection();
        $liveAwayPlayers = new Collection();

        // We need to remove the relations that are not in the id list
        // This is because the stats data is stored inside the relation table
        GamePlayer::query()->whereNotIn('player_id', $allPlayerIds)->where('game_id', $game->id)->delete();

        // Let's store all player relations
        foreach (['home' => $homePlayers, 'away' => $awayPlayers] as $side => $players) {
            foreach ($players as $player) {
                GamePlayer::query()->updateOrCreate([
                    'game_id'  => $game->id,
                    'player_id' => $player['id'],
                    'team_id'  => $player['pivot']['team_id']
                ], ['event_id' => $game->event_id]);

                if ($side === 'home') $liveHomePlayers->push($player);
                else                  $liveAwayPlayers->push($player);
            }
        }

        return to_route('live.players.starting', $game->id);
    }

    /**
     * Edit players  for teams, set starting players
     *
     * @param  Game $game
     * @return Response
     */
    public function playersStarting(Game $game): Response
    {
        // We need to convert all the data to an array
        $data = $this->live($game)->toData();

        return Inertia::render('PlayersStarting', $data);
    }

    /**
     * Store game players
     *
     * @param Game $game
     * @param Request $request
     */
    public function playersStartingStore(Game $game, Request $request)
    {
        $live          = $this->live($game);
        $startGame     = (bool) $request->input('start');
        $homePlayers   = $request->input('home_starting_players');
        $homePlayerIds = collect($homePlayers)->pluck('id')->toArray();
        $awayPlayers   = $request->input('away_starting_players');
        $awayPlayerIds = collect($awayPlayers)->pluck('id')->toArray();

        // Get the request data
        Log::debug("Home starting five. Game: {$game->id}, Players: " . @json_encode($homePlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);
        Log::debug("Away starting five. Game: {$game->id}, Players: " . @json_encode($awayPlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);
        $this->live($game)->addStartingPlayers(
            homePlayerIds: $homePlayerIds,
            awayPlayerIds: $awayPlayerIds
        );

        if ($startGame) {
            // We need to check the current live game status, if it's already started, don't add to log
            // dump($this->live($game));
            $game->update(['status' => 'scheduled']);
            // $live->startGame();
            return to_route('live.game', $game->id);
        }

        return to_route('live.players.starting', $game->id);
    }

    /**
     * The interface for keeping live score
     *
     * @param  Game $game
     * @return Response
     */
    public function score(Game $game)
    {
        // We need to convert all the data to an array
        $data = $this->live($game)->toData();

        return Inertia::render('Score', $data);
    }

    public function addMulti(Game $game, Request $request)
    {
        $action = $request->input('action');
        $type   = $request->input('type');

        if ($action === 'score')             $this->addScore($game, $request);
        elseif ($action === 'assist')        $this->addAssist($game, $request);
        elseif ($action === 'miss')          $this->addMiss($game, $request);
        elseif ($action === 'rebound')       $this->addRebound($game, $request);
        elseif ($action === 'steal')         $this->addSteal($game, $request);
        elseif ($action === 'block')         $this->addBlock($game, $request);
        elseif ($action === 'turnover')      $this->addTurnover($game, $request);
        elseif ($action === 'foul')          $this->addFoul($game, $request);
        elseif ($action === 'substitution') {
            $request->merge([
                'selectedPlayersOut' => [$request->input('selectedPlayer')],
                'selectedPlayersIn'  => [$request->input('selectedOtherPlayer')],
            ]);

            $this->substitution($game, $request);
        }
    }

    public function addScore(Game $game, Request $request)
    {
        // Prepare data
        $playerId       = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $assistPlayerId = $request->input('selectedOtherPlayer') ?  $request->input('selectedOtherPlayer')['id'] : null;
        $score          = $request->input('type');
        Log::debug("Adding score. Game: {$game->id}, Player: {$playerId}, Assist: {$assistPlayerId}, Score: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        if ($assistPlayerId) $this->live($game)->playerScore(playerId: $playerId, points: $score, playerAssistId: $assistPlayerId);
        else                 $this->live($game)->playerScore(playerId: $playerId, points: $score);

        // Sync with game
        $this->syncGame($game);

        LiveScoreUpdated::dispatch('addScore', [
            'playerId'       => $playerId,
            'assistPlayerId' => $assistPlayerId,
            'score'          => $score,
        ]);
    }

    public function addAssist(Game $game, Request $request)
    {
        // Add the assist
        $playerId      = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $otherPlayerId = $request->input('selectedOtherPlayer') ?  $request->input('selectedOtherPlayer')['id'] : null;
        $score         = $request->input('type');
        Log::debug("Adding assist. Game: {$game->id}, Player: {$playerId}, Assisted: {$otherPlayerId}, Score: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the assist and score
        if ($otherPlayerId) $this->live($game)->playerAssist(playerId: $playerId, points: $score, playerAssistToId: $otherPlayerId);
        else                $this->live($game)->playerAssist(playerId: $playerId, points: $score);

        // Sync with game
        $this->syncGame($game);

        LiveScoreUpdated::dispatch('addAssist', [
            'playerId'       => $playerId,
            'assistPlayerId' => $otherPlayerId,
            'score'          => $score,
        ]);
    }

    public function addMiss(Game $game, Request $request)
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $score    = $request->input('type');
        Log::debug("Adding miss. Game: {$game->id}, Player: {$playerId}, Points: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerMiss(playerId: $playerId, points: $score);

        LiveScoreUpdated::dispatch('addMiss');
    }

    public function addRebound(Game $game, Request $request): void
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $subtype  = $request->input('type') ?: 'reb';
        Log::debug("Adding rebound. Game: {$game->id}, Player: {$playerId}, Subtype: {$subtype}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerRebound(playerId: $playerId, subtype: $subtype);

        LiveScoreUpdated::dispatch('addRebound');
    }

    public function addSteal(Game $game, Request $request): void
    {
        // Find the player
        $playerId      = $request->input('selectedPlayer')      ?  $request->input('selectedPlayer')['id'] : null;
        $stealPlayerId = $request->input('selectedOtherPlayer') ?  $request->input('selectedOtherPlayer')['id'] : null;
        Log::debug("Adding steal. Game: {$game->id}, Player: {$playerId}, Player stolen: {$stealPlayerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerSteal(playerId: $playerId, playerStolenId: $stealPlayerId);

        LiveScoreUpdated::dispatch('addSteal');
    }

    public function addBlock(Game $game, Request $request)
    {
        // Find the player
        $playerId        = $request->input('selectedPlayer')        ?  $request->input('selectedPlayer')['id'] : null;
        $blockedPlayerId = $request->input('selectedBlockedPlayer') ?  $request->input('selectedBlockedPlayer')['id'] : null;
        Log::debug("Adding steal. Game: {$game->id}, Player: {$playerId}, Player blocked: {$blockedPlayerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerBlock(playerId: $playerId, playerBlockedId: $blockedPlayerId);

        LiveScoreUpdated::dispatch('addBlock');
    }

    public function addTurnover(Game $game, Request $request)
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        Log::debug("Adding turnover. Game: {$game->id}, Player: {$playerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerTurnover(playerId: $playerId);

        LiveScoreUpdated::dispatch('addTurnover');
    }

    public function addFoul(Game $game, Request $request)
    {
        // Find the player
        $playerId       = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $teamId         = $request->input('teamId') ?: null;
        $fouledPlayerId = $request->input('selectedFouledPlayer') ?  $request->input('selectedFouledPlayer')['id'] : null;
        $type           = request('type') ?: 'pf';

        if ($type === 'tf' && ! $playerId && $teamId) {
            Log::debug("Adding team technical foul. Game: {$game->id}, Team: {$teamId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

            $this->live($game)->teamTechnicalFoul(teamId: $teamId);
        } else {
            Log::debug("Adding foul. Game: {$game->id}, Player: {$playerId}, Player fouled: {$fouledPlayerId}, Type: {$type}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

            $this->live($game)->playerFoul(playerId: $playerId, subtype: $type, playerFouledId: $fouledPlayerId);
        }

        LiveScoreUpdated::dispatch('addFoul');
    }

    public function addTimeout(Game $game, Request $request)
    {
        // Find the team
        $teamId = $request->input('team_id');

        if ($this->live($game)->timeout(teamId: $teamId)) {
            Log::debug("Adding timeout. Game: {$game->id}, Team: {$teamId}");
        } else {
            Log::warning("No timeouts left. Game: {$game->id}, Team: {$teamId}");
        }

        LiveScoreUpdated::dispatch('addTimeout');
    }

    public function substitution(Game $game, Request $request)
    {
        // Find the player
        $playersIn     = (array) ($request->input('selectedPlayersIn') ?  $request->input('selectedPlayersIn') : null);
        $playersOut    = (array) ($request->input('selectedPlayersOut') ?  $request->input('selectedPlayersOut') : null);
        $playersInIds  = array_column($playersIn, 'id');
        $playersOutIds = array_column($playersOut, 'id');

        if (count($playersInIds) && count($playersInIds) && (count($playersInIds) === count($playersOutIds))) {
            Log::debug("Substitution. Game: {$game->id}, Players in: " . @json_encode($playersInIds) . ", Players out: " . @json_encode($playersOutIds) . ", ", ['section' => 'LIVE', 'game_id' => $game->id]);
            $this->live($game)->substitution(playersIn: $playersInIds, playersOut: $playersOutIds);
        } else {
            Log::error("Cant make substitution. Game: {$game->id}, Players in: " . @json_encode($playersInIds) . ", Players out: " . @json_encode($playersOutIds) . ", ", ['section' => 'LIVE', 'game_id' => $game->id]);
        }

        // $type           = request('subtype') ?: 'pf';


        LiveScoreUpdated::dispatch('substitution');
    }

    public function startGame(Game $game, Request $request)
    {
        Log::debug("Starting game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);
        $this->live($game)->startGame();
        Cache::clear();

        LiveScoreUpdated::dispatch('startGame', [
            'gameId'    => $game->id,
            'homeTeam'  => $game->homeTeam->title,
            'awayTeam'  => $game->awayTeam->title,
            'homeScore' => $game->home_score,
            'awayScore' => $game->away_score,
        ]);
    }

    public function nextPeriod(Game $game, Request $request)
    {
        // Find the player
        Log::debug("Next period. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        $this->live($game)->nextPeriod();

        // Sync with game
        $game = $this->syncGame($game);

        LiveScoreUpdated::dispatch('nextPeriod', [
            'gameId'    => $game->id,
            'period'    => $this->live($game)->currentPeriod(),
            'homeTeam'  => $game->homeTeam->title,
            'awayTeam'  => $game->awayTeam->title,
            'homeScore' => $game->home_score,
            'awayScore' => $game->away_score,
        ]);
    }

    public function endGame(Game $game, Request $request)
    {
        // Find the player
        Log::debug("Ending game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        $this->live($game)->endGame();

        // Sync with game
        $game = $this->syncGame($game);

        // Clear the cache
        Cache::clear();

        LiveScoreUpdated::dispatch('endGame', [
            'gameId'    => $game->id,
            'homeTeam'  => $game->homeTeam->title,
            'awayTeam'  => $game->awayTeam->title,
            'homeScore' => $game->home_score,
            'awayScore' => $game->away_score,
        ]);
    }

    public function resetGame(Game $game, Request $request)
    {
        Log::debug("Resetting game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        // Reset all stats and scores, delete log
        $this->live($game)->resetGame();

        // Sync with game
        $game = $this->syncGame($game);

        // Clear the cache
        Cache::clear();

        return to_route('live.players', $game->id);
    }

    public function deleteLog(GameLog $log)
    {
        if ($log->type === 'completed') {
            $log->game->update(['status' => 'in_progress']);
        } elseif ($log->type === 'game_started') {
            $log->game->update(['status' => 'scheduled']);
        } elseif ($log->type === 'period_started') {
            $log->game->update(['period' => $log->period - 1]);
        } elseif ($log->type === 'substitution') {
            // We need to revert the substitution
            $this->live($log->game)->substitution(playersIn: [$log->player_2_id], playersOut: [$log->player_id], addLog: false);
        }

        $log->delete();
        $this->live($log->game)->updateLiveStats();

        $this->syncGame($log->game);
    }

    // public function update(Game $game)
    // {
    //     // We need to update the game, and also write a log entry what happened


    //     $game->update([
    //         'score' => request('score'),
    //     ]);
    // }

    public function syncGame(Game $game): Game
    {
        // Sync live game periods
        foreach (range(1, 10) as $period) {
            $homeScore = GameLog::where('game_id', $game->id)->where('type', 'LIKE', 'player_score%')->where('period', $period)->where('team_side', 'home')->sum('amount');
            $awayScore = GameLog::where('game_id', $game->id)->where('type', 'LIKE', 'player_score%')->where('period', $period)->where('team_side', 'away')->sum('amount');

            $game->update([
                'home_score_p' . $period => $homeScore,
                'away_score_p' . $period => $awayScore,
            ]);
        }

        return $game;
    }

    protected function live(Game $game): LiveScore
    {
        if (! $this->live) {
            $this->live = new LiveScore($game);
        }

        return $this->live;
    }
}
