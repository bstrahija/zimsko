<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait StatsTeams
{
    /**
     * Generate DB data from a game
     * Usually called after a game is finished
     * TODO: Think about if we also update stats for the parent event, and maybe also total stats
     *
     * @param GameLive $gameLive
     * @return void
     */
    public static function generateFromGameForTeams(Game $game): void
    {
        // First we cleanup any existing stats for this game
        // Stat::where(['game_id' => $game->id, 'for' => 'team'])->delete();

        if ($game->status === 'completed') {
            // Next we go through the teams and collect stats
            foreach (['home' => $game->homeTeam, 'away' => $game->awayTeam] as $side => $team) {
                // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
                $statData = ['games' => 1];

                // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
                foreach (config('stats.columns') as $column) {
                    $statData[$column['id']] = isset($game->{$side . '_' . $column['id']}) ? $game->{$side . '_' . $column['id']} : 0;
                }

                // Win / loss
                $statData['wins']   = $side === 'home' ? $game->home_score > $game->away_score : $game->away_score > $game->home_score;
                $statData['losses'] = !$statData['wins'];

                // We also need to calculate the score against and difference
                $statData['score_against'] = $side === 'home' ? $game->away_score : $game->home_score;
                $statData['score_diff']    = $side === 'home' ? $game->home_score - $game->away_score : $game->away_score - $game->home_score;
                foreach (range(1, 10) as $p) {
                    $statData['score_p' . $p . '_against'] = $side === 'home' ? $game->{'away_score_p' . $p} : $game->{'home_score_p' . $p};
                    $statData['score_p' . $p . '_diff']    = $side === 'home' ? $game->{'home_score_p' . $p} - $game->{'away_score_p' . $p} : $game->{'away_score_p' . $p} - $game->{'home_score_p' . $p};
                }

                // Insert it into the DB
                Stat::query()->updateOrCreate([
                    'type'      => 'game',
                    'for'       => 'team',
                    'event_id'  => $game->event_id,
                    'game_id'   => $game->id,
                    'team_id'   => $team->id,
                ], $statData);
            }
        }
    }

    /**
     * Generate stats for all games in specific event
     *
     * @param  Event $event
     * @return void
     */
    public static function generateFromEventForTeams(Event $event, $generateForGames = false, Game $game = null)
    {
        // Clean out everything
        // Stat::where(['event_id' => $event->id, 'for' => 'team', 'type' => 'event'])->delete();

        if ($game && $generateForGames) {
            self::generateFromGameForTeams($game);
        } else {
            // Generate stats for each game
            if ($generateForGames) {
                // Get all the  games
                $games = $event->games()->where('status', 'completed')->get();

                foreach ($games as $game) {
                    self::generateFromGameForTeams($game);
                }
            }
        }

        // Once we have data for all games, we generate for the event
        $teamEventStats = [];
        $rows           = Stat::where('event_id', $event->id)->where('for', 'team')->where('type', 'game')->get();

        foreach ($rows as $row) {
            // Check if we already have stats for this team
            if (! isset($teamEventStats[$row->team_id])) {
                $teamEventStats[$row->team_id] = ['games' => 0];

                foreach (config('stats.columns') as $column) {
                    $teamEventStats[$row->team_id][$column['id']] = 0;
                }

                foreach (config('stats.calculated_columns') as $column) {
                    $teamEventStats[$row->team_id][$column['id']] = 0;
                }
            }

            // Now we add games
            $teamEventStats[$row->team_id]['games']++;

            // Add stats
            foreach (config('stats.columns') as $column) {
                $teamEventStats[$row->team_id][$column['id']] += $row[$column['id']];
            }

            // Here we do calculations for all the calculated columns
            foreach (config('stats.calculated_columns') as $column) {
                if ($column['method'] === 'avg') {
                    $teamEventStats[$row->team_id][$column['id']] = $teamEventStats[$row->team_id]['games'] ? round($teamEventStats[$row->team_id][str_replace('_avg', '', $column['id'])] / $teamEventStats[$row->team_id]['games'], 2) : 0;
                } elseif ($column['method'] === 'percent') {
                    $attemptColumn = str_replace('_percent', '', $column['id']);
                    $madeColumn    = $attemptColumn . '_made';
                    $attempted     = $teamEventStats[$row->team_id][$attemptColumn];
                    $made          = $teamEventStats[$row->team_id][$madeColumn];
                    $teamEventStats[$row->team_id][$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
                } elseif ($column['method'] === 'efficiency') {
                    $teamEventStats[$row->team_id][$column['id']] = Stats::calculateEfficiency($teamEventStats[$row->team_id]);
                }
            }
        }

        // Write the to the DB
        foreach ($teamEventStats as $teamId => $stats) {
            Stat::query()->updateOrCreate([
                'type'      => 'event',
                'for'       => 'team',
                'event_id'  => $event->id,
                'team_id'   => $teamId,
            ], $stats);
        }
    }

    /**
     * This takes the existing stats for all games in the stats table, and updates total stats
     *
     * @param  GameLive $gameLive
     * @return void
     */
    public static function generateTotalForTeams($generateForEvents = false, $generateForGames = false, Event $event = null): void
    {
        if ($generateForEvents) {
            if ($event) {
                Log::debug('-- Generating total team stats for event: ' . $event->slug);
                self::generateFromEventForTeams(event: $event, generateForGames: $generateForGames);
            } else {
                $events = Event::all();

                Log::debug('-- Generating total team stats for all events.');
                foreach ($events as $event) {
                    Log::debug('-- -- Generating total team stats for event: ' . $event->slug);
                    self::generateFromEventForTeams(event: $event, generateForGames: $generateForGames);
                }
            }
        }


        die();

        // Once we have data for all games, we generate for the event
        $teamTotalStats = [];
        $rows           = Stat::where('for', 'team')->where('type', 'event')->get();

        foreach ($rows as $row) {
            // Check if we already have stats for this team
            if (! isset($teamTotalStats[$row->team_id])) {
                $teamTotalStats[$row->team_id] = ['games' => 0];

                foreach (config('stats.columns') as $column) {
                    $teamTotalStats[$row->team_id][$column['id']] = 0;
                }

                foreach (config('stats.calculated_columns') as $column) {
                    $teamTotalStats[$row->team_id][$column['id']] = 0;
                }
            }

            // Now we add games
            $teamTotalStats[$row->team_id]['games'] += $row->games;

            // Add stats
            foreach (config('stats.columns') as $column) {
                $teamTotalStats[$row->team_id][$column['id']] += $row[$column['id']];
            }

            // Here we do calculations for all the calculated columns
            foreach (config('stats.calculated_columns') as $column) {
                if ($column['method'] === 'avg') {
                    $teamTotalStats[$row->team_id][$column['id']] = $teamTotalStats[$row->team_id]['games'] ? round($teamTotalStats[$row->team_id][str_replace('_avg', '', $column['id'])] / $teamTotalStats[$row->team_id]['games'], 2) : 0;
                } elseif ($column['method'] === 'percent') {
                    $attemptColumn = str_replace('_percent', '', $column['id']);
                    $madeColumn    = $attemptColumn . '_made';
                    $attempted     = $teamTotalStats[$row->team_id][$attemptColumn];
                    $made          = $teamTotalStats[$row->team_id][$madeColumn];
                    $teamTotalStats[$row->team_id][$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
                } elseif ($column['method'] === 'efficiency') {
                    $teamTotalStats[$row->team_id][$column['id']] = Stats::calculateEfficiency($teamTotalStats[$row->team_id]);
                }
            }
        }

        // Write the to the DB
        foreach ($teamTotalStats as $teamId => $stats) {
            Stat::query()->updateOrCreate([
                'type'      => 'total',
                'for'       => 'team',
                'team_id'   => $teamId,
            ], $stats);
        }
    }

    public static function generateTotalForPlayers($generateForEvents = false, $generateForGames = false, $event = null)
    {
        $events = Event::with(['games'])->get();

        if ($generateForEvents) {
            if ($event) {
                Log::debug('-- Generating total player stats for event: ' . $event->slug);
                self::generateFromEventForPlayers(event: $event, generateForGames: $generateForGames);
            } else {
                Log::debug('-- Generating total player stats for all events.');
                foreach ($events as $event) {
                    Log::debug('-- -- Generating total player stats for event: ' . $event->slug);
                    self::generateFromEventForPlayers(event: $event, generateForGames: $generateForGames);
                }
            }
        }

        // Once we have data for all games, we generate the totals
        $playerTotalStats = [];
        $rows             = Stat::where('for', 'player')->where('type', 'event')->get();

        foreach ($rows as $row) {
            // Check if we already have stats for this player
            if (! isset($playerTotalStats[$row->player_id])) {
                $playerTotalStats[$row->player_id] = ['games' => 0];

                foreach (config('stats.columns') as $column) {
                    $playerTotalStats[$row->player_id][$column['id']] = 0;
                }

                foreach (config('stats.calculated_columns') as $column) {
                    $playerTotalStats[$row->player_id][$column['id']] = 0;
                }
            }

            // Now we add games
            $playerTotalStats[$row->player_id]['games'] += $row->games;

            // Add stats
            foreach (config('stats.columns') as $column) {
                $playerTotalStats[$row->player_id][$column['id']] += $row[$column['id']];
            }

            // Here we do calculations for all the calculated columns
            foreach (config('stats.calculated_columns') as $column) {
                if ($column['method'] === 'avg') {
                    $playerTotalStats[$row->player_id][$column['id']] = $playerTotalStats[$row->player_id]['games'] ? round($playerTotalStats[$row->player_id][str_replace('_avg', '', $column['id'])] / $playerTotalStats[$row->player_id]['games'], 2) : 0;
                } elseif ($column['method'] === 'percent') {
                    $attemptColumn = str_replace('_percent', '', $column['id']);
                    $madeColumn    = $attemptColumn . '_made';
                    $attempted     = $playerTotalStats[$row->player_id][$attemptColumn];
                    $made          = $playerTotalStats[$row->player_id][$madeColumn];
                    $playerTotalStats[$row->player_id][$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
                } elseif ($column['method'] === 'efficiency') {
                    $playerTotalStats[$row->player_id][$column['id']] = Stats::calculateEfficiency($playerTotalStats[$row->player_id]);
                }
            }
        }

        // Write the to the DB
        foreach ($playerTotalStats as $playerId => $stats) {
            Stat::query()->updateOrCreate([
                'type'      => 'total',
                'for'       => 'player',
                'player_id' => $playerId,
            ], $stats);
        }
    }
}
