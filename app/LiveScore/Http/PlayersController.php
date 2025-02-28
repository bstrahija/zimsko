<?php

namespace App\LiveScore\Http;

use App\LiveScore\LiveScore;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\PlayerTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class PlayersController extends BaseController
{
    /**
     * Manage the players for a game
     *
     * @param  Game $game
     * @return InertiaResponse
     */
    public function index(Game $game): InertiaResponse
    {
        $data = LiveScore::build($game)->toData();

        return Inertia::render('Players', $data);
    }

    /**
     * Update the players for a game
     *
     * @param  Game $game
     * @param  Request $request
     * @return RedirectResponse
     */
    public function update(Game $game, Request $request): RedirectResponse
    {
        $homePlayers     = $request->input('home_players');
        $homePlayerIds   = collect($homePlayers)->pluck('id')->toArray();
        $awayPlayers     = $request->input('away_players');
        $awayPlayerIds   = collect($awayPlayers)->pluck('id')->toArray();
        $allPlayerIds    = array_merge($homePlayerIds, $awayPlayerIds);
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

        return to_route('live.players.starting.index', $game->id);
    }

    /**
     * Manage the starting players for a game
     *
     * @param  Game $game
     * @return InertiaResponse
     */
    public function startingIndex(Game $game): InertiaResponse
    {
        $data = LiveScore::build($game)->toData();

        return Inertia::render('PlayersStarting', $data);
    }

    /**
     * Update the starting players for a game
     *
     * @param  Game $game
     * @return RedirectResponse
     */
    public function startingUpdate(Game $game, Request $request): RedirectResponse
    {
        $live          = LiveScore::build($game);
        $startGame     = (bool) $request->input('start');
        $homePlayerIds = $request->input('home_starting_players');
        $awayPlayerIds = $request->input('away_starting_players');

        // Add to log
        Log::debug("Home starting five. Game: {$game->id}, Players: " . @json_encode($homePlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);
        Log::debug("Away starting five. Game: {$game->id}, Players: " . @json_encode($awayPlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);

        // If the game is in progress, we make substitutions
        if ($game->status !== 'in_progress') {
            LiveScore::build($game)->addStartingPlayers(
                homePlayerIds: $homePlayerIds,
                awayPlayerIds: $awayPlayerIds
            );
        } else {
            LiveScore::build($game)->updatePlayersOnCourt(
                homePlayerIds: $homePlayerIds,
                awayPlayerIds: $awayPlayerIds
            );
        }

        if ($startGame) {
            // We need to check the current live game status, if it's already started, don't add to log
            // $live->startGame();
            return to_route('live.score.show', $game->id);
        }

        return to_route('live.players.starting.index', $game->id);
    }

    public function onCourtIndex(Game $game): InertiaResponse
    {
        $data = LiveScore::build($game)->toData();

        return Inertia::render('PlayersOnCourt', $data);
    }

    /**
     * Update the starting players for a game
     *
     * @param  Game $game
     * @return RedirectResponse
     */
    public function onCourtUpdate(Game $game, Request $request): RedirectResponse
    {
        $live          = LiveScore::build($game);
        $homePlayerIds = $request->input('home_players_on_court');
        $awayPlayerIds = $request->input('away_players_on_court');

        // Add to log
        Log::debug("Home five players. Game: {$game->id}, Players: " . @json_encode($homePlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);
        Log::debug("Away five players. Game: {$game->id}, Players: " . @json_encode($awayPlayerIds), ['section' => 'LIVE', 'game_id' => $game->id]);

        // If the game is in progress, we make substitutions
        LiveScore::build($game)->updatePlayersOnCourt(
            homePlayerIds: $homePlayerIds,
            awayPlayerIds: $awayPlayerIds
        );

        return to_route('live.score.show', $game->id);
    }

    public function updateNumbers(Game $game, Request $request): RedirectResponse
    {
        if ($request->input('home_players') && $request->input('home_team_id')) {
            foreach ($request->input('home_players') as $player) {
                PlayerTeam::where('player_id', $player['id'])->where('team_id', $request->input('home_team_id'))->update(['number' => $player['number']]);
            }
        }

        if ($request->input('away_players') && $request->input('away_team_id')) {
            foreach ($request->input('away_players') as $player) {
                PlayerTeam::where('player_id', $player['id'])->where('team_id', $request->input('away_team_id'))->update(['number' => $player['number']]);
            }
        }

        return to_route('live.players.index', $game->id);
    }
}
