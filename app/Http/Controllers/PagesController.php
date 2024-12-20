<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameTeam;
use App\Services\Leaderboards;
use App\Services\Settings;
use App\Services\Stats;
use Illuminate\Database\Eloquent\Model;

class PagesController extends Controller
{
    public function index()
    {
        // $game = Game::find('01jfft1r4gbp635vqvwe4vpdrx');
        // dump($game->toArray());
        // dump($game->homeTeamNumbers->toArray());
        // dump($game->awayTeamNumbers->toArray());
        // die();


        // $event = Event::find('01jffj029drq5jf4g7s69kfq4t');

        // Model::shouldBeStrict(false);
        // $result = Stats::generateFromGameForTeams($game);
        // Stats::generateFromEventForTeams($event);
        // // dump($result);
        // $result = Stats::generateFromGameForPlayers($game);
        // Stats::generateFromEventForPlayers($event);
        // // dump($result);
        // Model::shouldBeStrict();
        // dd($game->toArray());



        $lastEvent         = Event::last()->toArray();
        $currentEvent      = Event::current();
        $latestGames       = Game::where('status', 'completed')->with(['homeTeam', 'awayTeam', 'homeTeamNumbers', 'awayTeamNumbers'])->limit(5)->get();
        $upcomingGames     = Game::where('status', 'upcoming')->with(['homeTeam', 'awayTeam'])->get();
        $leaderboard       = Leaderboards::getTeamLeaderboardForEvent($currentEvent);
        $leaderboardPoints = Leaderboards::getPlayerLeaderboardForEvent($currentEvent);
        $leaderboard3Point = Leaderboards::getPlayer3PointLeaderboardForEvent($currentEvent);

        // foreach ($latestGames as $game) {
        //     dump($game->toArray());
        //     dump(GameTeam::where(['game_id' => $game->id, 'team_id' => $game->home_team_id])->first());
        //     dump(GameTeam::where(['game_id' => $game->id, 'team_id' => $game->away_team_id])->first());
        //     // dump($game->homeTeamNumbers);
        //     echo '<pre>';
        //     print_r("===");
        //     echo '</pre>';
        // }
        // die();

        return view('index', [
            'currentEvent'      => $currentEvent,
            'latestGames'       => $latestGames,
            'upcomingGames'     => $upcomingGames,
            'leaderboard'       => $leaderboard,
            'leaderboardPoints' => $leaderboardPoints,
            'leaderboard3Point' => $leaderboard3Point,
        ]);
    }
}
