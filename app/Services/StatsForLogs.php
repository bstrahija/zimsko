<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\GameLog;
use App\Models\GamePlayer;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait StatsForLogs
{
    /**
     * This is used mostly when you have no data in the game and game_player tables
     * It pull all the logs and fill data in those 2 tables for the entire event
     *
     * @param  Event $event
     * @return void
     * @throws BindingResolutionException
     */
    public static function addStatsFromLogToGameDataForEvent(Event $event)
    {
        // Get all completed games for event
        $games = Game::where('event_id', $event->id)->where('status', 'completed')->get();

        foreach ($games as $game) {
            // Get logs for each game
            $log = GameLog::where('game_id', $game->id)->get();

            // Simply pull the total scores from the last log entry
            $game->home_score = $log->sortByDesc('id')->first()?->home_score ?: 0;
            $game->away_score = $log->sortByDesc('id')->first()?->away_score ?: 0;

            // Add scores to teams
            foreach (['home', 'away'] as $side) {
                // Scores per quarter
                foreach (range(1, 10) as $period) {
                    $game->{$side . '_score_p' . $period} = $log->where('team_side', $side)->where('period', $period)->where('type', 'player_score')->sum('amount') ?: 0;
                }

                // Scoring stats
                $game->{$side . '_field_goals_made'}   = $log->where('team_side', $side)->where('type', 'player_score')->where('amount', '>', 1)->count() ?: 0;
                $game->{$side . '_field_goals'}        = $game->{$side . '_field_goals_made'} + $log->where('team_side', $side)->where('type', 'player_miss')->where('amount', '>', 1)->count() ?: 0;
                $game->{$side . '_free_throws_made'}   = $log->where('team_side', $side)->where('type', 'player_score')->where('amount', 1)->count() ?: 0;
                $game->{$side . '_free_throws'}        = $game->{$side . '_free_throws_made'} + $log->where('team_side', $side)->where('type', 'player_miss')->where('amount', 1)->count() ?: 0;
                $game->{$side . '_two_points_made'}    = $log->where('team_side', $side)->where('type', 'player_score')->where('amount', 2)->count() ?: 0;
                $game->{$side . '_two_points'}         = $game->{$side . '_two_points_made'} + $log->where('team_side', $side)->where('type', 'player_miss')->where('amount', 2)->count() ?: 0;
                $game->{$side . '_three_points_made'}  = $log->where('team_side', $side)->where('type', 'player_score')->where('amount', 3)->count() ?: 0;
                $game->{$side . '_three_points'}       = $game->{$side . '_three_points_made'} + $log->where('team_side', $side)->where('type', 'player_miss')->where('amount', 3)->count() ?: 0;

                // Other stats
                $game->{$side . '_assists'}            = $log->where('team_side', $side)->where('type', 'player_assist')->count() ?: 0;
                $game->{$side . '_rebounds'}           = $log->where('team_side', $side)->where('type', 'player_rebound')->count() ?: 0;
                $game->{$side . '_defensive_rebounds'} = $log->where('team_side', $side)->where('type', 'player_rebound')->where('subtype', 'def')->count() ?: 0;
                $game->{$side . '_offensive_rebounds'} = $log->where('team_side', $side)->where('type', 'player_rebound')->where('subtype', 'off')->count() ?: 0;
                $game->{$side . '_blocks'}             = $log->where('team_side', $side)->where('type', 'player_block')->count() ?: 0;
                $game->{$side . '_steals'}             = $log->where('team_side', $side)->where('type', 'player_steal')->count() ?: 0;
                $game->{$side . '_fouls'}              = $log->where('team_side', $side)->where('type', 'player_foul')->count() ?: 0;
                $game->{$side . '_personal_fouls'}     = $log->where('team_side', $side)->where('type', 'player_foul')->where('subtype', 'pf')->count() ?: 0;
                $game->{$side . '_technical_fouls'}    = $log->where('team_side', $side)->where('type', 'player_foul')->where('subtype', 'tf')->count() ?: 0;
                $game->{$side . '_flagrant_fouls'}     = $log->where('team_side', $side)->where('type', 'player_foul')->where('subtype', 'ff')->count() ?: 0;
                $game->{$side . '_turnovers'}          = $log->where('team_side', $side)->where('type', 'player_turnover')->count() ?: 0;
                $game->{$side . '_timeouts'}           = $log->where('team_side', $side)->where('type', 'timeout')->count() ?: 0;
            }

            // Finally update the game
            $game->save();

            // Then add scores for players
            $playerStats = new Collection();
            foreach (['home' => $game->homePlayers()->get(), 'away' => $game->awayPlayers()->get()] as $side => $players) {
                foreach ($players as $player) {
                    // First let's add the player score
                    $stat = [
                        'event_id' => $game->event_id,
                        'game_id'  => $game->id,
                        'team_id'  => $player->pivot->team_id,
                        'score'    => $log->where('player_id', $player->id)->where('type', 'player_score')->sum('amount') ?: 0,
                    ];

                    // Scores per quarter
                    foreach (range(1, 10) as $period) {
                        $stat['score_p' . $period] = $log->where('player_id', $player->id)->where('period', $period)->where('type', 'player_score')->sum('amount') ?: 0;
                    }

                    // Scoring stats
                    $stat['field_goals_made']   = $log->where('player_id', $player->id)->where('type', 'player_score')->where('amount', '>', 1)->count() ?: 0;
                    $stat['field_goals']        = $game->{$side . '_field_goals_made'} + $log->where('player_id', $player->id)->where('type', 'player_miss')->where('amount', '>', 1)->count() ?: 0;
                    $stat['free_throws_made']   = $log->where('player_id', $player->id)->where('type', 'player_score')->where('amount', 1)->count() ?: 0;
                    $stat['free_throws']        = $game->{$side . '_free_throws_made'} + $log->where('player_id', $player->id)->where('type', 'player_miss')->where('amount', 1)->count() ?: 0;
                    $stat['two_points_made']    = $log->where('player_id', $player->id)->where('type', 'player_score')->where('amount', 2)->count() ?: 0;
                    $stat['two_points']         = $game->{$side . '_two_points_made'} + $log->where('player_id', $player->id)->where('type', 'player_miss')->where('amount', 2)->count() ?: 0;
                    $stat['three_points_made']  = $log->where('player_id', $player->id)->where('type', 'player_score')->where('amount', 3)->count() ?: 0;
                    $stat['three_points']       = $game->{$side . '_three_points_made'} + $log->where('player_id', $player->id)->where('type', 'player_miss')->where('amount', 3)->count() ?: 0;

                    // Other stats
                    $stat['assists']            = $log->where('player_id', $player->id)->where('type', 'player_assist')->count() ?: 0;
                    $stat['rebounds']           = $log->where('player_id', $player->id)->where('type', 'player_rebound')->count() ?: 0;
                    $stat['defensive_rebounds'] = $log->where('player_id', $player->id)->where('type', 'player_rebound')->where('subtype', 'def')->count() ?: 0;
                    $stat['offensive_rebounds'] = $log->where('player_id', $player->id)->where('type', 'player_rebound')->where('subtype', 'off')->count() ?: 0;
                    $stat['blocks']             = $log->where('player_id', $player->id)->where('type', 'player_block')->count() ?: 0;
                    $stat['steals']             = $log->where('player_id', $player->id)->where('type', 'player_steal')->count() ?: 0;
                    $stat['fouls']              = $log->where('player_id', $player->id)->where('type', 'player_foul')->count() ?: 0;
                    $stat['personal_fouls']     = $log->where('player_id', $player->id)->where('type', 'player_foul')->where('subtype', 'pf')->count() ?: 0;
                    $stat['technical_fouls']    = $log->where('player_id', $player->id)->where('type', 'player_foul')->where('subtype', 'tf')->count() ?: 0;
                    $stat['flagrant_fouls']     = $log->where('player_id', $player->id)->where('type', 'player_foul')->where('subtype', 'ff')->count() ?: 0;
                    $stat['turnovers']          = $log->where('player_id', $player->id)->where('type', 'player_turnover')->count() ?: 0;
                    $stat['timeouts']           = $log->where('player_id', $player->id)->where('type', 'timeout')->count() ?: 0;

                    // Save
                    GamePlayer::updateOrCreate(['game_id' => $game->id, 'player_id' => $player->id], $stat);
                    $playerStats->push($stat);
                }
            }
        }
    }
}
