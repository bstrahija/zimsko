<?php

namespace App\Http\Controllers;

use App\Legacy\Sync3pts;
use App\Legacy\SyncRounds;
use App\Models\Event;
use App\Models\Game;
use App\Models\GameTeam;
use App\Models\Stat;
use App\Services\Leaderboards;
use App\Services\Settings;
use App\Services\Stats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PagesController extends Controller
{
    public function index()
    {
        // Try syncing three pointers
        // Sync3pts::run();
        // SyncRounds::run();


        // die();




        // Stats::generateTotalForTeams(generateForEvents: true, generateForGames: true);
        // Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true);
        // die();
        // $game = Game::find('01jfmhadet2cq2kghhn38nd93y');
        // $event = Event::where('slug', 'zimsko-2024')->with('games', 'games.homeTeam', 'games.awayTeam')->first();
        // $result = Stats::generateFromGameForTeams($game);
        // $result = Stats::generateFromEventForPlayers($event, true);


        // die();

        // Get data for home page
        $lastEvent         = Event::last()->toArray();
        $currentEvent      = Event::current();
        $latestGames       = Game::where('status', 'completed')->with(['homeTeam', 'awayTeam'])->limit(8)->get();
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
