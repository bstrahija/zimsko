<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\GameLog;
use App\Models\Player;
use App\Services\LiveScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LiveController extends Controller
{
    protected ?LiveScore $live = null;

    public function index()
    {
        // Let's get a game (latest)
        // $game = Game::orderBy('scheduled_at', 'desc')->first();

        /** @var Game $game */
        $game = Game::where('id', '01je1krqjrfafqe8ywf1htcawh')->with(['homeTeam', 'awayTeam', 'homeTeam.players', 'awayTeam.players'])->first();
        // $this->runSim($game, true);
        // Log::debug("Simulating game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);



        // die();

        $live = $this->live($game);
        // dump($live);
        // die();



        // We need to convert all the data to an array
        $data = $this->live($game)->toData();

        // dump($data);
        // die();





        return Inertia::render('Score', $data);
    }

    public function show(Game $game)
    {
        return Inertia::render('Score', [
            'game' => $game,
        ]);
    }

    public function addScore(Game $game, Request $request)
    {
        // Prepare data
        $playerId       = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $assistPlayerId = $request->input('selectedAssistPlayer') ?  $request->input('selectedAssistPlayer')['id'] : null;
        $score          = $request->input('score');
        Log::debug("Adding score. Game: {$game->id}, Player: {$playerId}, Assist: {$assistPlayerId}, Score: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        if ($assistPlayerId) $this->live($game)->playerScore(playerId: $playerId, points: $score, playerAssistId: $assistPlayerId);
        else                 $this->live($game)->playerScore(playerId: $playerId, points: $score);
    }

    public function addMiss(Game $game, Request $request)
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $score    = $request->input('score');
        Log::debug("Adding miss. Game: {$game->id}, Player: {$playerId}, Points: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerMiss(playerId: $playerId, points: $score);
    }

    public function addRebound(Game $game, Request $request)
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $score    = $request->input('score');
        $subtype  = $request->input('subtype') ?: 'reb';
        Log::debug("Adding rebound. Game: {$game->id}, Player: {$playerId}, Points: {$score}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerRebound(playerId: $playerId, subtype: $subtype);
    }

    public function addSteal(Game $game, Request $request)
    {
        // Find the player
        $playerId      = $request->input('selectedPlayer')      ?  $request->input('selectedPlayer')['id'] : null;
        $stealPlayerId = $request->input('selectedStealPlayer') ?  $request->input('selectedStealPlayer')['id'] : null;
        Log::debug("Adding steal. Game: {$game->id}, Player: {$playerId}, Player stolen: {$stealPlayerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerSteal(playerId: $playerId, playerStolenId: $stealPlayerId);
    }

    public function addBlock(Game $game, Request $request)
    {
        // Find the player
        $playerId        = $request->input('selectedPlayer')        ?  $request->input('selectedPlayer')['id'] : null;
        $blockedPlayerId = $request->input('selectedBlockedPlayer') ?  $request->input('selectedBlockedPlayer')['id'] : null;
        Log::debug("Adding steal. Game: {$game->id}, Player: {$playerId}, Player blocked: {$blockedPlayerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerBlock(playerId: $playerId, playerBlockedId: $blockedPlayerId);
    }

    public function addTurnover(Game $game, Request $request)
    {
        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        Log::debug("Adding turnover. Game: {$game->id}, Player: {$playerId}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        // Write the score
        $this->live($game)->playerTurnover(playerId: $playerId);
    }

    public function addFoul(Game $game, Request $request)
    {
        // Find the player
        $playerId       = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        $fouledPlayerId = $request->input('selectedFouledPlayer') ?  $request->input('selectedFouledPlayer')['id'] : null;
        $type           = request('subtype') ?: 'pf';
        Log::debug("Adding foul. Game: {$game->id}, Player: {$playerId}, Player fouled: {$fouledPlayerId}, Type: {$type}", ['section' => 'LIVE', 'game_id' => $game->id, 'player_id' => $playerId]);

        $this->live($game)->playerFoul(playerId: $playerId, subtype: $type, playerFouledId: $fouledPlayerId);
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


        //
    }



    public function startGame(Game $game, Request $request)
    {
        // Find the player
        Log::debug("Starting game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        $this->live($game)->startGame();
    }

    public function nextPeriod(Game $game, Request $request)
    {
        // Find the player
        Log::debug("Next period. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        $this->live($game)->nextPeriod();
    }

    public function endGame(Game $game, Request $request)
    {
        // Find the player
        Log::debug("Ending game. Game: {$game->id}", ['section' => 'LIVE', 'game_id' => $game->id]);

        $this->live($game)->endGame();
    }

    public function deleteLog(GameLog $log)
    {
        $log->delete();
        $this->live($log->game)->updateLiveStats();
    }

    public function update(Game $game)
    {
        // We need to update the game, and also write a log entry what happened


        $game->update([
            'score' => request('score'),
        ]);
    }

    /**
     * Simulate a game
     *
     * @param  Game $game
     * @return LiveScore
     */
    protected function runSim(Game $game, bool $fresh = false): LiveScore
    {
        // Delete live game entry
        if ($fresh) {
            GameLog::where('game_id', $game->id)->delete();
            GameLive::where('game_id', $game->id)->delete();
        }

        // We need the service (this initializes the game, we'll see if this if good like this)
        $live = new LiveScore($game);

        // Clear the log
        $live->clearLog();

        // Some player numbers (home - ppč, away - basket case)
        $players = [
            'vedran' => Player::findByTeamAndNumber($live->awayTeam()->id, 45),
            'srdjan' => Player::findByTeamAndNumber($live->awayTeam()->id, 44),
            'medo'   => Player::findByTeamAndNumber($live->awayTeam()->id, 13),
            'bis'    => Player::findByTeamAndNumber($live->awayTeam()->id, 23),
            'megla'  => Player::findByTeamAndNumber($live->awayTeam()->id, 15),
            'gomzi'  => Player::findByTeamAndNumber($live->awayTeam()->id, 1),
            'sale'   => Player::findByTeamAndNumber($live->awayTeam()->id, 77),
            'vurac'  => Player::findByTeamAndNumber($live->awayTeam()->id, 39),
            'stanic' => Player::findByTeamAndNumber($live->awayTeam()->id, 28),
            'ivano'  => Player::findByTeamAndNumber($live->awayTeam()->id, 10),

            'medica' => Player::findByTeamAndNumber($live->homeTeam()->id, 16),
            'niko'   => Player::findByTeamAndNumber($live->homeTeam()->id, 44),
            'soric'  => Player::findByTeamAndNumber($live->homeTeam()->id, 88),
            'volf'   => Player::findByTeamAndNumber($live->homeTeam()->id, 13),
            'milic'  => Player::findByTeamAndNumber($live->homeTeam()->id, 1),
            'kraja'  => Player::findByTeamAndNumber($live->homeTeam()->id, 31),
            'marek'  => Player::findByTeamAndNumber($live->homeTeam()->id, 6),
            'halic'  => Player::findByTeamAndNumber($live->homeTeam()->id, 77),
            'varga'  => Player::findByTeamAndNumber($live->homeTeam()->id, 7),
        ];

        // Add starting players for both teams
        $live->addStartingPlayers(
            awayPlayerIds: [$players['ivano']->id, $players['vurac']->id, $players['vedran']->id, $players['medo']->id, $players['bis']->id],
            homePlayerIds: [$players['milic']->id, $players['kraja']->id, $players['marek']->id, $players['volf']->id, $players['medica']->id]
        );

        // Start the game
        // $live->startGame();

        // Q1 Sim
        $live->playerScore(playerId: $players['vedran']->id, points: 2, occurredAt: '00:00:44');
        $live->playerScore(playerId: $players['medica']->id, playerAssistId: $players['milic']->id, points: 2, occurredAt: '00:01:08');
        $live->playerSteal(playerId: $players['volf']->id, playerStolenId: $players['bis']->id, occurredAt: '00:01:12');
        $live->playerMiss(playerId: $players['milic']->id, points: 2, occurredAt: '00:01:30');
        $live->playerFoul(playerId: $players['bis']->id, playerFouledId: $players['medica']->id, points: 2, occurredAt: '00:01:51');
        $live->playerScore(playerId: $players['medica']->id, points: 1, occurredAt: '00:01:51');
        $live->playerMiss(playerId: $players['medica']->id, points: 1, occurredAt: '00:01:51');
        $live->playerFoul(playerId: $players['medica']->id, playerFouledId: $players['medo']->id, points: 2, occurredAt: '00:01:59');
        $live->substitution(playersIn: [$players['megla']->id], playersOut: [$players['ivano']->id], occurredAt: '00:02:00');
        $live->playerScore(playerId: $players['megla']->id, playerAssistId: $players['vurac']->id, points: 3, occurredAt: '00:02:08');
        $live->playerSteal(playerId: $players['bis']->id, playerStolenId: $players['kraja']->id, occurredAt: '00:02:31');
        $live->playerScore(playerId: $players['medo']->id, playerAssistId: $players['bis']->id, points: 3, occurredAt: '00:02:33');
        $live->playerFoul(playerId: $players['bis']->id, playerFouledId: $players['medo']->id, occurredAt: '00:02:51');
        $live->playerScore(playerId: $players['medica']->id, points: 1, occurredAt: '00:02:51');
        $live->playerScore(playerId: $players['medica']->id, points: 1, occurredAt: '00:02:51');
        $live->timeout(teamId: $live->awayTeam()->id, occurredAt: '00:03:12');
        $live->playerScore(playerId: $players['bis']->id, playerAssistId: $players['medo']->id, points: 2, occurredAt: '00:03:33');
        $live->playerScore(playerId: $players['bis']->id, points: 3, occurredAt: '00:03:55');
        $live->playerScore(playerId: $players['marek']->id, points: 3, occurredAt: '00:03:59');
        $live->playerScore(playerId: $players['marek']->id, playerAssistId: $players['kraja']->id, points: 3, occurredAt: '00:04:15');
        $live->playerFoul(playerId: $players['vedran']->id, playerFouledId: $players['kraja']->id, occurredAt: '00:04:33');
        $live->playerScore(playerId: $players['kraja']->id, points: 1, occurredAt: '00:04:33');
        $live->playerScore(playerId: $players['kraja']->id, points: 1, occurredAt: '00:04:33');
        $live->playerScore(playerId: $players['megla']->id, points: 3, occurredAt: '00:04:44');
        $live->substitution(playersIn: [$players['gomzi']->id], playersOut: [$players['bis']->id], occurredAt: '00:02:00');
        $live->playerScore(playerId: $players['gomzi']->id, playerAssistId: $players['megla']->id, points: 2, occurredAt: '00:04:44');


        // $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        // $live->playerScore(playerId: $players['vedran']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->substitution(playersOut: [$players['bis']->id, $players['vedran']->id], playersIn: [$players['medo']->id, $players['davorin']->id]);
        // $live->substitution(playersOut: [$players['lesar']->id], playersIn: [$players['nevco']->id]);
        // $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        // $live->playerScore(playerId: $players['gego']->id, points: 2);
        // $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        // $live->playerScore(playerId: $players['alex']->id, points: 3);
        // $live->timeout(teamId: $live->awayTeam()->id);
        // $live->playerScore(playerId: $players['danc']->id, points: 2);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->timeout(teamId: $live->homeTeam()->id);
        // $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        // $live->playerFoul(playerId: $players['gego']->id, playerFouledId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 1);
        // $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        // $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        // $live->playerMiss(playerId: $players['bis']->id, points: 1);
        // $live->timeout(teamId: $live->homeTeam()->id);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerMiss(playerId: $players['danc']->id, points: 1);
        // $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        // $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // dump($live);
        // $live->nextPeriod();

        // Q2 Sim
        // $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        // $live->playerScore(playerId: $players['gego']->id, points: 2);
        // $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        // $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        // $live->playerMiss(playerId: $players['bis']->id, points: 1);
        // $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        // $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 1);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerScore(playerId: $players['vedran']->id, points: 2);
        // $live->playerScore(playerId: $players['alex']->id, points: 3);
        // $live->playerScore(playerId: $players['danc']->id, points: 2);
        // $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        // dump($live);
        // $live->nextPeriod();

        // Q3 Sim
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        // $live->playerScore(playerId: $players['gego']->id, points: 2);
        // $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        // $live->playerMiss(playerId: $players['bis']->id, points: 1);
        // $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        // $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        // $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 1);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerScore(playerId: $players['alex']->id, points: 3);
        // $live->playerScore(playerId: $players['danc']->id, points: 2);
        // $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 3);
        // $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerScore(playerId: $players['vedran']->id, points: 2);
        // dump($live);
        // $live->nextPeriod();

        // Q4 Sim
        // $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['bis']->id, points: 2);
        // $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        // $live->playerScore(playerId: $players['gego']->id, points: 2);
        // $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        // $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        // $live->playerScore(playerId: $players['bis']->id, points: 1);
        // $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerScore(playerId: $players['danc']->id, points: 1);
        // $live->playerMiss(playerId: $players['bis']->id, points: 1);
        // $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        // $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        // $live->playerScore(playerId: $players['vedran']->id, points: 2);
        // $live->playerScore(playerId: $players['alex']->id, points: 3);
        // $live->playerScore(playerId: $players['danc']->id, points: 2);
        // $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        // $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        // $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);

        // And finish the game
        // $live->endGame();

        // dump($live);
        // dump($live->players()->toArray());

        // echo '<hr><ul>';
        // foreach ($live->logStream() as $log) {
        //     echo '<li>' . $log['period'] . ' [' . $log['occurred_at_p']  . '] (' . $log['home_score'] . ' : ' . $log['away_score'] . '): ' . $log['message'] . '</li>';
        // }
        // echo '</ul>';

        return $live;
    }

    protected function live(Game $game): LiveScore
    {
        if (! $this->live) {
            $this->live = new LiveScore($game);
        }

        return $this->live;
    }
}