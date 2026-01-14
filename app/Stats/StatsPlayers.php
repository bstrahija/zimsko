<?php

namespace App\Stats;

use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;

trait StatsPlayers
{
    /**
     * Generate DB data from a game
     * Usually called after a game is finished
     * TODO: Think about if we also update stats for the parent event, and maybe also total stats
     */
    public static function generateFromGameForPlayers(Game $game): void
    {
        // Clean up any existing stats for player in this game
        // Stat::where('game_id', $game->id)->where('for', 'player')->delete();

        if ($game->status === 'completed') {
            foreach (['home' => $game->homePlayers, 'away' => $game->awayPlayers] as $side => $players) {
                foreach ($players as $player) {
                    $statData = ['games' => 0];

                    // Now we add games
                    $statData['games']++;

                    // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
                    foreach (config('stats.columns') as $column) {
                        $statData[$column['id']] = $player->pivot->{$column['id']};
                    }

                    // Here we do calculations for all the calculated columns
                    foreach (config('stats.calculated_columns') as $column) {
                        if ($column['method'] === 'avg') {
                            $statData[$column['id']] = $statData['games'] ? round($statData[str_replace('_avg', '', $column['id'])] / $statData['games'], 2) : 0;
                        } elseif ($column['method'] === 'miss') {
                            $attemptColumn           = str_replace('_missed', '', $column['id']);
                            $madeColumn              = $attemptColumn . '_made';
                            $attempted               = $statData[$attemptColumn];
                            $made                    = $statData[$madeColumn];
                            $statData[$column['id']] = $attempted - $made;
                        } elseif ($column['method'] === 'percent') {
                            $attemptColumn           = str_replace('_percent', '', $column['id']);
                            $madeColumn              = $attemptColumn . '_made';
                            $attempted               = $statData[$attemptColumn];
                            $made                    = $statData[$madeColumn];
                            $statData[$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
                        }
                    }

                    // Calculate efficiency after all other
                    $statData['efficiency'] = Stats::calculateEfficiency($statData);

                    // Remove some things
                    unset($statData['field_goals_missed']);
                    unset($statData['free_throws_missed']);

                    // Create the record
                    Stat::query()->updateOrCreate([
                        'type'      => 'game',
                        'for'       => 'player',
                        'event_id'  => $game->event_id,
                        'game_id'   => $game->id,
                        'player_id' => $player->id,
                        'team_id'   => $side === 'home' ? $game->homeTeam->id : $game->awayTeam->id,
                    ], $statData);
                }
            }
        }
    }

    /**
     * Generate stats for all games in specific event
     *
     * @return void
     */
    public static function generateFromEventForPlayers(Event $event, $generateForGames = false)
    {
        // Clean out everything
        // Stat::where(['event_id' => $event->id, 'for' => 'player', 'type' => 'event'])->delete();

        if ($generateForGames) {
            foreach ($event->games as $game) {
                self::generateFromGameForPlayers($game);
            }
        }

        // Once we have data for all games, we generate for the event
        $playerEventStats = [];
        $rows             = Stat::where('event_id', $event->id)->where('for', 'player')->where('type', 'game')->get();

        foreach ($rows as $row) {
            // Check if we already have stats for this player
            if (! isset($playerEventStats[$row->player_id])) {
                $playerEventStats[$row->player_id] = ['games' => 0];

                foreach (config('stats.columns') as $column) {
                    $playerEventStats[$row->player_id][$column['id']] = 0;
                }

                foreach (config('stats.calculated_columns') as $column) {
                    $playerEventStats[$row->player_id][$column['id']] = 0;
                }
            }

            // Add the team
            $playerEventStats[$row->player_id]['team_id'] = $row->team_id;

            // Now we add games
            $playerEventStats[$row->player_id]['games']++;

            // Add stats
            foreach (config('stats.columns') as $column) {
                $playerEventStats[$row->player_id][$column['id']] += $row[$column['id']];
            }

            // Here we do calculations for all the calculated columns
            foreach (config('stats.calculated_columns') as $column) {
                if ($column['method'] === 'avg') {
                    $playerEventStats[$row->player_id][$column['id']] = $playerEventStats[$row->player_id]['games'] ? round($playerEventStats[$row->player_id][str_replace('_avg', '', $column['id'])] / $playerEventStats[$row->player_id]['games'], 2) : 0;
                } elseif ($column['method'] === 'percent') {
                    $attemptColumn                                    = str_replace('_percent', '', $column['id']);
                    $madeColumn                                       = $attemptColumn . '_made';
                    $attempted                                        = $playerEventStats[$row->player_id][$attemptColumn];
                    $made                                             = $playerEventStats[$row->player_id][$madeColumn];
                    $playerEventStats[$row->player_id][$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
                } elseif ($column['method'] === 'efficiency') {
                    $playerEventStats[$row->player_id][$column['id']] = Stats::calculateEfficiency($playerEventStats[$row->player_id]);
                }
            }
        }

        // Write the to the DB
        foreach ($playerEventStats as $playerId => $stats) {
            $teamId = $stats['team_id'];
            unset($stats['team_id']);
            unset($stats['field_goals_missed']);
            unset($stats['free_throws_missed']);

            Stat::query()->updateOrCreate([
                'type'      => 'event',
                'for'       => 'player',
                'event_id'  => $event->id,
                'player_id' => $playerId,
                'team_id'   => $teamId,
            ], $stats);
        }
    }

    public static function playerEventStats(int $playerId, ?Event $event = null): ?array
    {
        if (! $event) {
            $event = Event::current();
        }

        $stats = Stat::where('for', 'player')
            ->with(['player', 'player.media'])
            ->where('type', 'event')
            ->where('event_id', $event->id)
            ->where('player_id', $playerId)
            ->first();

        return $stats ? $stats->toArray() : null;
    }

    /**
     * Get aggregated stats for a player across all events
     */
    public static function playerAllEventsStats(int $playerId): ?array
    {
        $rows = Stat::where('for', 'player')
            ->where('type', 'event')
            ->where('player_id', $playerId)
            ->get();

        if ($rows->isEmpty()) {
            return null;
        }

        $aggregated = ['games' => 0];

        foreach (config('stats.columns') as $column) {
            $aggregated[$column['id']] = 0;
        }

        foreach ($rows as $row) {
            $aggregated['games'] += $row->games;

            foreach (config('stats.columns') as $column) {
                $aggregated[$column['id']] += $row->{$column['id']};
            }
        }

        // Calculate averages and percentages
        foreach (config('stats.calculated_columns') as $column) {
            if ($column['method'] === 'avg') {
                $baseColumn                = str_replace('_avg', '', $column['id']);
                $aggregated[$column['id']] = $aggregated['games'] ? round($aggregated[$baseColumn] / $aggregated['games'], 2) : 0;
            } elseif ($column['method'] === 'percent') {
                $attemptColumn             = str_replace('_percent', '', $column['id']);
                $madeColumn                = $attemptColumn . '_made';
                $attempted                 = $aggregated[$attemptColumn];
                $made                      = $aggregated[$madeColumn];
                $aggregated[$column['id']] = $attempted ? round($made / $attempted * 100, 2) : 0;
            } elseif ($column['method'] === 'efficiency') {
                $aggregated[$column['id']] = Stats::calculateEfficiency($aggregated);
            }
        }

        return $aggregated;
    }
}
