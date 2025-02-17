<?php

namespace App\LiveScore\Http;

use App\Jobs\GenerateTotalStats;
use App\LiveScore\Actions\DeleteLogEntry;
use App\LiveScore\Actions\EndGame;
use App\LiveScore\Actions\NextPeriod;
use App\LiveScore\Actions\ResetGame;
use App\LiveScore\Actions\StartGame;
use App\LiveScore\Events\LiveScoreUpdated;
use App\LiveScore\LiveScore;
use App\Models\Event;
use App\Models\Game;
use App\Models\GameLog;
use App\Services\Cache;
use App\Stats\Stats;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class ScoreController extends BaseController
{
    /**
     * Display panel for adding game stats
     *
     * @param  Game $game
     * @return InertiaResponse
     */
    public function show(Game $game): InertiaResponse
    {
        $data = LiveScore::build($game)->toData();

        return Inertia::render('Score', $data);
    }

    /**
     * Start the game
     *
     * @param  Game $game
     * @return void
     */
    public function startGame(Game $game): void
    {
        app(StartGame::class)->handle($game->id);
    }

    /**
     * End game
     *
     * @param  Game $game
     * @return void
     */
    public function endGame(Game $game): void
    {
        app(EndGame::class)->handle($game->id);
    }

    /**
     * Go to next period
     *
     * @param Game $game
     * @return void
     * @throws BindingResolutionException
     */
    public function nextPeriod(Game $game)
    {
        app(NextPeriod::class)->handle($game->id);

        return Inertia::location(route('live.players.on_court.index', $game->id));
    }

    public function resetGame(Game $game)
    {
        app(ResetGame::class)->handle($game->id);

        return to_route('live.players.index', $game->id);
    }

    /**
     * Delete log entry
     *
     * @param  GameLog $log
     * @return void
     */
    public function deleteLogEntry(GameLog $log)
    {
        app(DeleteLogEntry::class)->handle($log->id);
    }

    /**
     * Update game stats from the panel
     *
     * @param  Game $game
     * @param  Request $request
     */
    public function update(Game $game, Request $request)
    {
        $live = LiveScore::build($game);

        // Simply create log entry with the request data
        $live->addStatFromRequest($request);
    }

    public function generateStats(Request $request)
    {
        $event = $request->get('event') ? Event::find($request->get('event')) : Event::current();
        GenerateTotalStats::dispatch($event);
    }
}
