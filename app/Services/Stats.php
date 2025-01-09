<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\Player;
use App\Models\Stat;
use App\Models\Team;
use Illuminate\Support\Collection;

class Stats
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
     * Generate DB data from a game
     * Usually called after a game is finished
     * TODO: Think about if we also update stats for the parent event, and maybe also total stats
     *
     * @param GameLive $gameLive
     * @return void
     */
    public static function generateFromGameForPlayers(Game $game): void
    {
        // Clean up any existing stats for player in this game
        // Stat::where('game_id', $game->id)->where('for', 'player')->delete();

        if ($game->status === 'completed') {
            foreach (['home' => $game->homePlayers, 'away' => $game->awayPlayers] as $side => $players) {
                foreach ($players as $player) {
                    $statData = [];

                    // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
                    foreach (config('stats.columns') as $column) {
                        $statData[$column['id']] = $player->pivot->{$column['id']};
                    }

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
     * Generate DB data from a live game
     * Usually called after a game is finished
     * TODO: Think about if we also update stats for the parent event, and maybe also total stats
     *
     * @param GameLive $gameLive
     * @return void
     */
    public static function generateFromLiveGameForTeams(GameLive $gameLive): void
    {
        // First we cleanup any existing stats for this game
        Stat::where('game_id', $gameLive->game_id)->delete();

        // Now get the game log data
        $data = (new LiveScore($gameLive->game))->toData();

        // Then we go on to generating stats for each team
        foreach (['home', 'away'] as $side) {
            $team     = $data['game'][$side . '_team'];
            $stats    = $team['stats'];
            $statData = [
                'type'      => 'game',
                'for'       => 'team',
                'event_id'  => $gameLive->game->event_id,
                'game_id'   => $gameLive->game_id,
                'team_id'   => $team['id'],
                'score'     => $data['game'][$side . '_score'],
            ];

            // Add the rest of the stats
            foreach (config('stats.columns') as $column) {
                $statData[$column] = isset($stats[$column]) ? $stats[$column] : $stats[$column];
            }

            // Insert it into the DB
            Stat::query()->create($statData);
        }
    }

    /**
     * Generate DB data from a live game
     * Usually called after a game is finished
     * TODO: Think about if we also update stats for the parent event, and maybe also total stats
     *
     * @param GameLive $gameLive
     * @return void
     */
    public static function generateFromLiveGameForPlayers(GameLive $gameLive): void
    {
        // Now get the game log data
        $data = (new LiveScore($gameLive->game))->toData();

        // Clean up any existing stats for player in this game
        Stat::where('game_id', $gameLive->game_id)->where('for', 'player')->delete();

        // Then we go on to generating stats for each team
        foreach (['home', 'away'] as $side) {
            $team    = $data['game'][$side . '_team'];
            $players = $data['game'][$side . '_players'];

            foreach ($players as $player) {
                $stats = $player['stats'];

                $statData = [
                    'type'      => 'game',
                    'for'       => 'player',
                    'event_id'  => $gameLive->game->event_id,
                    'game_id'   => $gameLive->game_id,
                    'team_id'   => $team['id'],
                    'player_id' => $player['id'],
                ];

                // Add the rest of the stats
                foreach (config('stats.columns') as $column) {
                    $statData[$column] = $stats[$column];
                }

                // Insert it into the DB
                Stat::query()->create($statData);
            }
        }
    }

    /**
     * Generate stats for all games in specific event
     *
     * @param  Event $event
     * @return void
     */
    public static function generateFromEventForTeams(Event $event, $generateForGames = false)
    {
        // Clean out everything
        // Stat::where(['event_id' => $event->id, 'for' => 'team', 'type' => 'event'])->delete();

        // Get all the  games
        $games = $event->games()->where('status', 'completed')->get();

        // Generate stats for each game
        if ($generateForGames) {
            foreach ($games as $game) {
                self::generateFromGameForTeams($game);
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
     * Generate stats for all games in specific event
     *
     * @param  Event $event
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
                    $attemptColumn = str_replace('_percent', '', $column['id']);
                    $madeColumn    = $attemptColumn . '_made';
                    $attempted     = $playerEventStats[$row->player_id][$attemptColumn];
                    $made          = $playerEventStats[$row->player_id][$madeColumn];
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

            Stat::query()->updateOrCreate([
                'type'      => 'event',
                'for'       => 'player',
                'event_id'  => $event->id,
                'player_id' => $playerId,
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
    public static function generateTotalForTeams($generateForEvents = false, $generateForGames = false): void
    {
        $events = Event::all();

        if ($generateForEvents) {
            foreach ($events as $event) {
                self::generateFromEventForTeams(event: $event, generateForGames: $generateForGames);
            }
        }

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

    public static function generateTotalForPlayers($generateForEvents = false, $generateForGames = false)
    {
        $events = Event::with(['games'])->get();

        if ($generateForEvents) {
            foreach ($events as $event) {
                self::generateFromEventForPlayers(event: $event, generateForGames: $generateForGames);
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

    public static function calculateEfficiency(array $data)
    {
        // Check for missing data
        if (!isset($data['field_goals_missed'])) {
            $data['field_goals_missed'] = $data['field_goals'] - $data['field_goals_made'];
        }
        if (!isset($data['free_throws_missed'])) {
            $data['free_throws_missed'] = $data['free_throws'] - $data['free_throws_made'];
        }

        $efficiency = $data['score']
            + $data['rebounds']
            + $data['assists']
            + $data['steals']
            + $data['blocks']
            - $data['field_goals_missed']
            - $data['free_throws_missed']
            - $data['turnovers']
            - $data['fouls']
            - $data['score_against'];

        return $efficiency;
    }
}
