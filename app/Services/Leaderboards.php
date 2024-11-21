<?php

namespace App\Services;

use App\Leaderboards\Leaderboard;
use App\Leaderboards\LeaderboardPlayerItem;
use App\Leaderboards\LeaderboardTeamItem;
use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Team;
use Illuminate\Support\Collection;

class Leaderboards
{
    public static function getTeamLeaderboardForEvent(Event $event, int $limit = 20): Collection
    {
        $leaderboard = new Leaderboard;

        // Get all teams in tournament
        $teams = $event->teams;

        // Get all games in tournament
        $games = $event->games()->with(['homeTeam', 'awayTeam'])->get();

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
            $leaderboard->push(new LeaderboardTeamItem([
                'id'              => $team->id,
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
        ])->values()->take($limit);

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

    public static function getPlayerLeaderboardForEvent(Event $event, $orderBy = 'points', $limit = 10): Leaderboard
    {
        $leaderboard = new Leaderboard;

        // Get all games in tournament
        $games = $event->games;

        // All the player data is in the game_player table
        $players = new Collection;
        $records = GamePlayer::whereIn('game_id', $games->pluck('id'))->with(['player', 'team'])->get();

        // Now loop through records and add points to player stats
        foreach ($records as $record) {
            // First check if we already have the player in our collection
            if (! $players->where('id', $record->player_id)->first()) {
                $record->player->statsData['team'] = $record->team;
                $players->push($record->player);
            }

            // Add stats data to player
            // @TODO: Add more data later, eg. rebounds, assists, etc.
            $player = $players->where('id', $record->player_id)->first();
            $player->statsData['games']++;
            $player->statsData['points']             += $record->points;
            $player->statsData['three_points']     += $record->three_points;
            $player->statsData['avg']                 = round($player->statsData['points'] / $player->statsData['games'], 2);
            $player->statsData['avg_three_points']  = round($player->statsData['three_points'] / $player->statsData['games'], 2);
        }

        // Now create standings collection
        foreach ($players as $player) {
            $leaderboard->push(new LeaderboardPlayerItem([
                'id'               => $player->id,
                'title'            => $player->name,
                'games'            => $player->statsData['games'],
                'points'           => $player->statsData['points'],
                'three_points'     => $player->statsData['three_points'],
                'avg'              => $player->statsData['avg'],
                'avg_three_points' => $player->statsData['avg_three_points'],
                'player'           => $player,
                'team'             => $player->statsData['team'] ?: $player->teams->first(),
            ]));
        }

        // Now finish the advanced ordering
        $leaderboard = $leaderboard->sortByDesc($orderBy, SORT_NUMERIC)->values()->take($limit);

        return $leaderboard;
    }

    public static function getPlayer3PointLeaderboardForEvent(Event $event, $limit = 10): Leaderboard
    {
        return self::getPlayerLeaderboardForEvent($event, 'threePointers', $limit);
    }
}
