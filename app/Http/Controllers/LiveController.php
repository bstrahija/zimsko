<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Player;
use App\Services\LiveScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LiveController extends Controller
{
    public function index()
    {
        // Let's get a game (latest)
        // $game = Game::orderBy('scheduled_at', 'desc')->first();
        $game = Game::where('id', '01jcr1f3w6bfw1kmpq42wanz99')->first();
        // $this->runSim($game);

        $live = new LiveScore($game);

        // We need to convert all the data to an array
        $data = $live->toArray();
        // dump($data);




        return Inertia::render('Score', $data);
    }

    public function show(Game $game)
    {
        return Inertia::render('Score', [
            'game' => $game,
        ]);
    }

    function addScore(Game $game, Request $request)
    {
        $live = new LiveScore($game);

        // Find the player
        $playerId = $request->input('selectedPlayer') ?  $request->input('selectedPlayer')['id'] : null;
        // $player   = $playerId ? Player::where('id', $playerId)->first() : null;
        $assistPlayerId = $request->input('selectedAssistPlayer') ?  $request->input('selectedAssistPlayer')['id'] : null;
        // $assistPlayer   = $assistPlayerId ? Player::where('id', $assistPlayerId)->first() : null;
        $score    = $request->input('score');

        echo '<pre>';
        print_r($playerId);
        echo '</pre>';
        echo '<pre>';
        print_r($assistPlayerId);
        echo '</pre>';

        // Write the score
        // if ($assistPlayerId) $live->playerScore(playerId: $playerId, points: $score, playerAssistId: $assistPlayerId);
        // else                 $live->playerScore(playerId: $playerId, points: $score);
    }

    public function update(Game $game)
    {
        // We need to update the game, and also write a log entry what happened


        $game->update([
            'score' => request('score'),
        ]);
    }

    protected function runSim(Game $game)
    {
        // We need the service (this initializes the game, we'll see if this if good like this)
        $live = new LiveScore($game);

        // Clear the log
        $live->clearLog();

        // Some player numbers (home - ppč, away - basket case)
        $players = [
            'vedran'  => Player::findByTeamAndNumber($live->awayTeam()->id, 45),
            'srdjan'  => Player::findByTeamAndNumber($live->awayTeam()->id, 44),
            'medo'    => Player::findByTeamAndNumber($live->awayTeam()->id, 13),
            'bis'     => Player::findByTeamAndNumber($live->awayTeam()->id, 23),
            'markec'  => Player::findByTeamAndNumber($live->awayTeam()->id, 99),
            'gomzi'   => Player::findByTeamAndNumber($live->awayTeam()->id, 1),
            'davorin' => Player::findByTeamAndNumber($live->awayTeam()->id, 10),
            'lesar'   => Player::findByTeamAndNumber($live->homeTeam()->id, 1),
            'alex'    => Player::findByTeamAndNumber($live->homeTeam()->id, 3),
            'danc'    => Player::findByTeamAndNumber($live->homeTeam()->id, 17),
            'mađar'   => Player::findByTeamAndNumber($live->homeTeam()->id, 10),
            'cicka'   => Player::findByTeamAndNumber($live->homeTeam()->id, 4),
            'gego'    => Player::findByTeamAndNumber($live->homeTeam()->id, 2),
            'nevco'   => Player::findByTeamAndNumber($live->homeTeam()->id, 9),
        ];

        // Add starting players for both teams
        $live->addStartingPlayers(side: 'away', playerIds: [$players['vedran']->id, $players['srdjan']->id, $players['bis']->id, $players['markec']->id, $players['gomzi']->id]);
        $live->addStartingPlayers(side: 'home', playerIds: [$players['lesar']->id, $players['alex']->id, $players['danc']->id, $players['mađar']->id, $players['cicka']->id]);

        // Start the game
        $live->startGame();

        // Q1 Sim
        $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        $live->playerScore(playerId: $players['vedran']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->substitution(playersOut: [$players['bis']->id, $players['vedran']->id], playersIn: [$players['medo']->id, $players['davorin']->id]);
        $live->substitution(playersOut: [$players['lesar']->id], playersIn: [$players['nevco']->id]);
        $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        $live->playerScore(playerId: $players['gego']->id, points: 2);
        $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        $live->playerScore(playerId: $players['alex']->id, points: 3);
        $live->timeout(teamId: $live->awayTeam()->id);
        $live->playerScore(playerId: $players['danc']->id, points: 2);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->timeout(teamId: $live->homeTeam()->id);
        $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        $live->playerFoul(playerId: $players['gego']->id, playerFouledId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 1);
        $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        $live->playerMiss(playerId: $players['bis']->id, points: 1);
        $live->timeout(teamId: $live->homeTeam()->id);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerMiss(playerId: $players['danc']->id, points: 1);
        $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        dump($live);
        $live->nextQuarter();

        // Q2 Sim
        $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        $live->playerScore(playerId: $players['gego']->id, points: 2);
        $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        $live->playerMiss(playerId: $players['bis']->id, points: 1);
        $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 1);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerScore(playerId: $players['vedran']->id, points: 2);
        $live->playerScore(playerId: $players['alex']->id, points: 3);
        $live->playerScore(playerId: $players['danc']->id, points: 2);
        $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        dump($live);
        $live->nextQuarter();

        // Q3 Sim
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        $live->playerScore(playerId: $players['gego']->id, points: 2);
        $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        $live->playerMiss(playerId: $players['bis']->id, points: 1);
        $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 1);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerScore(playerId: $players['alex']->id, points: 3);
        $live->playerScore(playerId: $players['danc']->id, points: 2);
        $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 3);
        $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerScore(playerId: $players['vedran']->id, points: 2);
        dump($live);
        $live->nextQuarter();

        // Q4 Sim
        $live->playerScore(playerId: $players['markec']->id, playerAssistId: $players['srdjan']->id, points: 3);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['danc']->id, playerAssistId: $players['alex']->id, points: 2);
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['bis']->id, points: 2);
        $live->playerRebound(playerId: $players['srdjan']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['vedran']->id, points: 2, playerAssistId: $players['bis']->id);
        $live->playerScore(playerId: $players['gego']->id, points: 2);
        $live->playerSteal(playerId: $players['gomzi']->id, playerStolenId: $players['alex']->id);
        $live->playerBlock(playerId: $players['danc']->id, playerBlockedId: $players['bis']->id);
        $live->playerScore(playerId: $players['bis']->id, points: 1);
        $live->playerRebound(playerId: $players['bis']->id, subtype: 'oreb');
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerScore(playerId: $players['danc']->id, points: 1);
        $live->playerMiss(playerId: $players['bis']->id, points: 1);
        $live->playerBlock(playerId: $players['bis']->id, playerBlockedId: $players['gego']->id);
        $live->playerFoul(playerId: $players['danc']->id, playerFouledId: $players['bis']->id, points: 2);
        $live->playerScore(playerId: $players['vedran']->id, points: 2);
        $live->playerScore(playerId: $players['alex']->id, points: 3);
        $live->playerScore(playerId: $players['danc']->id, points: 2);
        $live->playerFoul(playerId: $players['medo']->id, subtype: 'tf');
        $live->playerRebound(playerId: $players['danc']->id, subtype: 'dreb');
        $live->playerScore(playerId: $players['srdjan']->id, points: 2, playerAssistId: $players['vedran']->id);

        // And finish the game
        $live->endGame();

        dump($live);
        // dump($live->players()->toArray());

        echo '<hr><ul>';
        foreach ($live->logStream() as $log) {
            echo '<li>' . $log['quarter'] . ' [' . $log['occurred_at_q']  . '] (' . $log['home_score'] . ' : ' . $log['away_score'] . '): ' . $log['message'] . '</li>';
        }
        echo '</ul>';
    }
}
