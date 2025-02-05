<?php

namespace App\LiveScore\Http;

use App\LiveScore\LiveScore;
use App\Models\Event;
use App\Models\Game;
use App\Models\Official;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class GamesController extends BaseController
{
    /**
     * List of live games
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): InertiaResponse
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
     * Create a new temporary game, and redirect to edit it
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
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
        return redirect()->route('live.games.edit', ['game' => $game]);
    }

    public function edit(Game $game): InertiaResponse
    {
        // Load referees
        $game = $game->load('referees');

        // We need to convert all the data to an array
        $data = LiveScore::build($game)->toData();

        // Add some additional data
        $data['currentEvent'] = Event::current() ?: Event::latest();
        $data['events']       = Event::active()->with(['teams', 'rounds'])->orderBy('scheduled_at', 'desc')->get()->toArray();
        $data['referees']     = Official::active()->referees()->orderBy('first_name')->get()->toArray();

        return Inertia::render('Details', $data);
    }

    public function update(Game $game, Request $request): RedirectResponse
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
            'status'       => ($game->status !== 'in_progress' && $game->status !== 'completed') ? 'scheduled' : $game->status,
        ]);
        $game->regenerateSlug();

        // Also do referees
        $game->referees()->detach();
        if ($request->input('refereeId1')) $game->referees()->attach($request->input('refereeId1'));
        if ($request->input('refereeId2')) $game->referees()->attach($request->input('refereeId2'));

        return to_route('live.players.index', $game->id);
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return to_route('live', ['event' => $game->event_id]);
    }
}
