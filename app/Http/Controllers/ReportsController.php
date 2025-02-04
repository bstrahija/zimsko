<?php

namespace App\Http\Controllers;

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
        $game = Game::with('event', 'homeTeam', 'awayTeam', 'homePlayers', 'awayPlayers', 'referees')->where('slug', $slug)->firstOrFail();

        $pdf = Pdf::loadView('reports.game', ['game' => $game]);

        // dd($pdf->output());
        // return $pdf->download('report.pdf');

        // Pdf::view('reports.game', ['game' => $game])
        //     ->format('a4')
        //     ->save('invoice.pdf');

        return view('reports.game', ['game' => $game]);
    }
}
