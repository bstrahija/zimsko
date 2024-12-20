<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Game;
use App\Models\GameLive;
use App\Models\Stat;

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
        Stat::where('game_id', $game->id)->delete();

        // Next we go through the teams and collect stats
        foreach (['home' => $game->homeTeam, 'away' => $game->awayTeam] as $side => $team) {
            // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
            $statData = [
                'type'      => 'game',
                'for'       => 'team',
                'event_id'  => $game->event_id,
                'game_id'   => $game->id,
                'team_id'   => $team->id,
            ];

            // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
            foreach (config('stats.columns') as $column) {
                $statData[$column] = isset($game->{$side . '_' . $column}) ? $game->{$side . '_' . $column} : 0;
            }

            // Insert it into the DB
            Stat::create($statData);
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
        Stat::where('game_id', $game->id)->where('for', 'player')->delete();

        foreach (['home' => $game->homePlayers, 'away' => $game->awayPlayers] as $side => $players) {
            foreach ($players as $player) {
                $statData = [
                    'type'      => 'game',
                    'for'       => 'player',
                    'event_id'  => $game->event_id,
                    'game_id'   => $game->id,
                    'player_id' => $player->id,
                    'team_id'   => $side === 'home' ? $game->homeTeam->id : $game->awayTeam->id,
                ];

                // Prepare the data (legacy data has no detailed stats like assists, rebounds, etc.)
                foreach (config('stats.columns') as $column) {
                    $statData[$column] = $player->pivot->{$column};
                }

                // Create the record
                Stat::create($statData);
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
            Stat::create($statData);
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
                Stat::create($statData);
            }
        }
    }

    /**
     * Generate stats for all games in specific event
     *
     * @param  Event $event
     * @return void
     */
    public static function generateFromEventForTeams(Event $event)
    {
        $games = $event->games;

        foreach ($games as $game) {
            self::generateFromGameForTeams($game);
        }
    }

    /**
     * Generate stats for all games in specific event
     *
     * @param  Event $event
     * @return void
     */
    public static function generateFromEventForPlayers(Event $event)
    {
        $games = $event->games;

        foreach ($games as $game) {
            self::generateFromGameForPlayers($game);
        }
    }

    /**
     * This takes the existing stats for all games in the stats table, and updates stats for the given event
     *
     * @param  Event $event
     * @return void
     */
    public static function updateForEvent(Event $event): void
    {
        // Keep in mind this will use already existing data in the stats table
        // To re-generate the stats, you need to generate data for all games first
    }

    /**
     * This takes the existing stats for all games in the stats table, and updates total stats
     *
     * @param  GameLive $gameLive
     * @return void
     */
    public static function updateTotal(): void
    {
        // Keep in mind this will use already existing data in the stats table
        // To re-generate the stats, you need to generate data for events first
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
            - $data['fouls'];

        return $efficiency;
    }
}
