<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Player;
use App\Models\Team;

final class Helpers
{
    protected static $currentEvent;

    protected static $currentTeams;

    protected static $cached = true;

    public static function leaderboard()
    {
        // return Leaderboards::getTeamLeaderboardForEvent(self::currentEvent());

        return Cache::remember('event_leaderboard.teams.'  . self::currentEvent()?->id, (60 * 60 * 24), fn() => Leaderboards::getTeamLeaderboardForEvent(self::currentEvent()));
    }

    public static function leaderboardPoints()
    {
        // return Leaderboards::getPlayerLeaderboardForEvent(self::currentEvent());

        return Cache::remember('event_leaderboard.points.' . self::currentEvent()?->id, (60 * 60 * 24), fn() => Leaderboards::getPlayerLeaderboardForEvent(self::currentEvent()));
    }

    public static function leaderboardThreePoints()
    {
        // return Leaderboards::getPlayer3PointLeaderboardForEvent(self::currentEvent());

        return Cache::remember('event_leaderboard.3pts.'  . self::currentEvent()?->id, (60 * 60 * 24), fn() => Leaderboards::getPlayer3PointLeaderboardForEvent(self::currentEvent()));
    }

    public static function currentTeams()
    {
        if (! self::$currentTeams) {
            self::$currentTeams = Cache::remember('event_teams.' . self::currentEvent()?->id, (60 * 60), fn() => self::currentEvent()->teams()->with('media')->orderBy('title')->get());
        }

        return self::$currentTeams;
    }

    public static function getSortedPlayerStats($live, $type, $limit = 20)
    {
        $players = array_merge($live['game']['home_players'], $live['game']['away_players']);

        // Add stats for each player
        foreach ($players as &$player) {
            $player['stats'] = $live['game']['player_stats']['player__' . $player['id']];
        }

        $sorted = collect($players)
            ->sortByDesc(function ($player) use ($live, $type) {
                return $player['stats'][$type] ?? 0;
            })
            ->take($limit)
            ->values()
            ->all();

        return $sorted;
    }

    public static function currentEvent()
    {
        if (! self::$currentEvent) {
            self::$currentEvent = Event::current();
        }

        return self::$currentEvent;
    }
}
