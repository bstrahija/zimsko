<?php

namespace App\Services;

use App\Leaderboards\Leaderboard;
use App\Leaderboards\LeaderboardPlayerItem;
use App\Leaderboards\LeaderboardTeamItem;
use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Collection;

class Leaderboards
{
    public static function getTeamLeaderboardForEvent(Event $event, int $limit = 20): Collection
    {
        $leaderboard = new Leaderboard;

        // First get the stats
        $stats = Stat::where(['event_id' => $event->id, 'for' => 'team', 'type' => 'event'])->with(['team'])->get();

        // The add to leaderboard
        foreach ($stats as $stat) {
            // Calculate the points based on the config
            $points = (config('stats.points_for_win') * $stat->wins) + (config('stats.points_for_loss') * $stat->losses);

            $leaderboard->add(new LeaderboardTeamItem([
                'id'              => $stat->team_id,
                'title'           => $stat->team->title,
                'points'          => $points,
                'wins'            => $stat->wins,
                'losses'          => $stat->losses,
                'games'           => $stat->games,
                'score'           => $stat->score,
                'opponentScore'   => $stat->score_against,
                'scoreDifference' => $stat->score_diff,
                'team'            => $stat->team,
            ]));
        }

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

    public static function getPlayerLeaderboardForEvent(Event $event, $orderBy = 'score', $limit = 10): Leaderboard
    {
        $leaderboard = new Leaderboard;

        // Get all stat rows
        $rows = Stat::where('event_id', $event->id)
            ->with(['player', 'team'])
            ->where('for', 'player')
            ->where('type', 'event')
            ->orderBy($orderBy, 'desc')
            ->take($limit)
            ->get();

        foreach ($rows as $row) {
            $data = array_merge($row->toArray(), [
                'title'  => $row->player->name,
                'player' => $row->player,
                'team'   => $row->team,
            ]);

            $player = new LeaderboardPlayerItem($data);
            $leaderboard->push($player);
        }

        return $leaderboard;
    }

    public static function getPlayer3PointLeaderboardForEvent(Event $event, $limit = 10): Leaderboard
    {
        return self::getPlayerLeaderboardForEvent($event, 'three_points', $limit);
    }
}
