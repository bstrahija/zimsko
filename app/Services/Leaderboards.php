<?php

namespace App\Services;

use App\Leaderboards\Leaderboard;
use App\Leaderboards\LeaderboardPlayerItem;
use App\Leaderboards\LeaderboardTeamItem;
use App\Models\Event;
use App\Models\Game;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Collection;

class Leaderboards
{
    public static function getTeamLeaderboardForEvent(Event $event, int $limit = 20): Collection
    {
        $leaderboard = (new Leaderboard)->setEvent($event);

        // Which leaderboard to use?
        $useManualLeaderboard = (bool) Settings::get('general.use_manual_leaderboard');

        // We can have manual leaderboards for teams, so we should take them into account
        if ($useManualLeaderboard) {
            $manualLeaderboard = $event->leaderboard;
        }

        // If we have a manual leaderboard, build up all data
        if ($useManualLeaderboard && isset($manualLeaderboard) && $manualLeaderboard) {
            $teams = $event->teams;

            foreach ($manualLeaderboard as $item) {
                $team = $teams->firstWhere('id', $item['team_id']);

                if ($team) {
                    $leaderboard->add(new LeaderboardTeamItem([
                        'id'              => $team->id,
                        'title'           => $team->title,
                        'points'          => $item['points'],
                        'wins'            => $item['wins'],
                        'losses'          => $item['loses'],
                        'games'           => $item['games'],
                        'score'           => 0,
                        'opponentScore'   => 0,
                        'scoreDifference' => $item['score'],
                        'team'            => $team,
                    ]));
                }
            }
        } else {
            // First get the stats
            $stats = Stat::query()->where(['event_id' => $event->id, 'for' => 'team', 'type' => 'event'])
                ->orderBy('score', 'desc')
                ->with(['team', 'team.media'])->get();

            // The add to leaderboard
            if ($stats?->count()) {
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

                // Generate empty leaderboard
            } else {
                foreach ($event->teams()->with(['media'])->get() as $team) {
                    $leaderboard->add(new LeaderboardTeamItem([
                        'id'    => $team->id,
                        'title' => $team->title,
                        // 'points'          => $points,
                        // 'wins'            => $stat->wins,
                        // 'losses'          => $stat->losses,
                        // 'games'           => $stat->games,
                        // 'score'           => $stat->score,
                        // 'opponentScore'   => $stat->score_against,
                        // 'scoreDifference' => $stat->score_diff,
                        'team' => $team,
                    ]));
                }
            }
        }

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
            $team->statsData['score'] += $game->home_score;
            $team->statsData['opponent_score'] += $game->away_score;
        } elseif ($team->id === $game->awayTeam->id) {
            $team->statsData['score'] += $game->away_score;
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
        $leaderboard = (new Leaderboard)->setEvent($event);

        // Get all stat rows
        $rows = Stat::where('event_id', $event->id)
            ->with(['player', 'player.media', 'team', 'team.media'])
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

    public static function getPlayerLeaderboardForGame(Game $game, $orderBy = 'score', $limit = 10): Leaderboard
    {
        $leaderboard = (new Leaderboard)->setGame($game)->setEvent($game->event);

        // Get all stat rows
        $rows = Stat::query()->where('game_id', $game->id)
            ->with(['player', 'team', 'player.media', 'team.media'])
            ->where('for', 'player')
            ->where('type', 'game')
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
        return self::getPlayerLeaderboardForEvent($event, 'three_points_made', $limit);
    }
}
