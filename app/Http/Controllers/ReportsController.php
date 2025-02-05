<?php

namespace App\Http\Controllers;

use App\LiveScore\LiveScore;
use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Services\Leaderboards;
use App\Services\Stats;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function game(string $slug)
    {
        $game = Game::where('slug', $slug)->firstOrFail();
        $live = LiveScore::build($game);
        $live = $live->toOptimizedData();

        // Merge players and order by points
        $live['game']['players'] = [];
        foreach (['home', 'away'] as $side) {
            foreach ($live['game'][$side . '_players'] as $player) {
                $player['team'] = $live['game'][$side . '_team'];
                $player['number'] = $player['pivot']['number'];
                $player['position'] = $player['pivot']['position'];
                $player['stats'] = isset($live['game']['player_stats']['player__' . $player['id']]) ? $live['game']['player_stats']['player__' . $player['id']] :  [];
                $player['score'] = $player['stats']['score'];
                $live['game']['players'][] = $player;
            }
        }
        $live['game']['players'] = collect($live['game']['players'])->sortByDesc('score')->values()->all();

        $pdf = Pdf::loadView('reports.game', ['game' => $live['game']]);

        return $pdf->download('report.pdf');

        // Pdf::view('reports.game', ['game' => $game])
        //     ->format('a4')
        //     ->save('invoice.pdf');

        // return view('reports.game', ['game' => $live['game']]);
    }
}
