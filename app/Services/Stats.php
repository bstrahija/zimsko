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
                'score'     => $game->{$side . '_score'},
                'score_p1'  => $game->{$side . '_score_p1'},
                'score_p2'  => $game->{$side . '_score_p2'},
                'score_p3'  => $game->{$side . '_score_p3'},
                'score_p4'  => $game->{$side . '_score_p4'},
                'score_p5'  => $game->{$side . '_score_p5'},
                'score_p6'  => $game->{$side . '_score_p6'},
                'score_p7'  => $game->{$side . '_score_p7'},
                'score_p8'  => $game->{$side . '_score_p8'},
            ];

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

        foreach ($game->players as $player) {
            dump($player->pivot->score);
        }

        // Insert it into the DB
        // Stat::create($statData);
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
}
