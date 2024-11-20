<?php

namespace App\Services;

use App\Leaderboards\Leaderboard;
use App\Leaderboards\LeaderboardItem;
use App\Models\Event;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Collection;

class Leaderboards
{
    public static function getForEvent(Event $event): Collection
    {
        $leaderboard = new Leaderboard;

        // Get all teams in tournament
        $teams = $event->teams;

        // Get all games in tournament
        $games = $event->games;

        // Loop through games and assign points to teams
        /** @var Game $game */
        foreach ($games as $game) {
            /** @var Team $team */
            foreach ($teams as &$team) {
                // dump($game->isCompleted());
                if ($game->isCompleted() && ($team->id === $game->homeTeam->id || $team->id === $game->awayTeam->id)) {
                    $team = self::addTeamGameStatsData($team, $game);
                }
            }
        }

        // Order teams by points and add required attributes
        $teams = $teams->sortByDesc(function ($team) {
            /** @var Team $team */
            return $team->statsData['points'];
        });

        // Now create standings collection
        foreach ($teams as $team) {
            $leaderboard->push(new LeaderboardItem([
                'points'          => $team->statsData['points'],
                'wins'            => $team->statsData['wins'],
                'losses'          => $team->statsData['losses'],
                'games'           => $team->statsData['games'],
                'score'           => $team->statsData['score'],
                'opponentScore'   => $team->statsData['opponent_score'],
                'scoreDifference' => $team->statsData['score'] - $team->statsData['opponent_score'],
                'team'            => $team,
            ]));
        }

        // Now finish the advanced ordering
        $leaderboard = $leaderboard->multiOrderBy([
            ['column' => 'points',          'order' => 'desc'],
            ['column' => 'scoreDifference', 'order' => 'desc'],
        ]);

        return $leaderboard;
    }

    public static function addTeamGameStatsData(Team $team, Game $game): Team
    {
        // Add match count to team stats data
        $team->statsData['games']++;

        // Add score
        if (
            $team->id === $game->homeTeam->id
        ) {
            $team->statsData['score']          += $game->home_score;
            $team->statsData['opponent_score'] += $game->away_score;
        } elseif ($team->id === $game->awayTeam->id) {
            $team->statsData['score']          += $game->away_score;
            $team->statsData['opponent_score'] += $game->home_score;
        }

        // Winner
        if ($game->winner() && $team->id === $game->winner()->id) {
            $team->statsData['points'] += 2;
            $team->statsData['wins']++;
        }

        // Loser
        if ($game->loser() && $team->id === $game->loser()->id) {
            $team->statsData['points'] += 1;
            $team->statsData['losses']++;
        }

        // Draw
        if ($game->isDraw()) {
            $team->statsData['points'] += 1;
        }

        return $team;
    }

    public static function getPointLeadersForEvent(): Leaderboard
    {
        $leaderboard = new Leaderboard;

        return $leaderboard;
    }

    public static function get3PointLeadersForEvent(): Leaderboard
    {
        $leaderboard = new Leaderboard;

        return $leaderboard;
    }
}
