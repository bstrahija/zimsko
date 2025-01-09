<?php

namespace App\Legacy;

use App\Jobs\SyncLegacyGame;
use App\Models\Event;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class SyncGames
{
    public static function run()
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_matches')->get()
            ->each(function ($game) {
                SyncLegacyGame::dispatch($game);
            });


        // TODO: We need to simulate three pointers from the last event
        // $event = Event::where('slug', 'zimsko-2024')->first();
        // if ($event) {
        // }
    }

    public static function syncGame($game)
    {
        // Check if game already exists
        $exists = Game::where('external_id', $game->wp_id)->first();

        if ($exists) {
            $newGame = $exists;
        } else {
            $newGame = new \App\Models\Game();
        }

        // Get the event for linking
        $legacyEvent = DB::connection('mysql_legacy')->table('wp_zmsk_events')->where('id', $game->event_id)->first();
        $event       = Event::where('external_id', $legacyEvent->wp_id)->first();

        // Also get the teams
        $legacyHomeTeam = DB::connection('mysql_legacy')->table('wp_zmsk_teams')->where('id', $game->home_team_id)->first();
        $legacyAwayTeam = DB::connection('mysql_legacy')->table('wp_zmsk_teams')->where('id', $game->away_team_id)->first();
        $homeTeam = Team::where('external_id', $legacyHomeTeam->wp_id)->first();
        $awayTeam = Team::where('external_id', $legacyAwayTeam->wp_id)->first();

        // Setup the status
        if ($game->status == 'finished') {
            $status = 'completed';
        } elseif ($game->status == 'upcoming') {
            $status = 'scheduled';
        } else {
            $status = 'draft';
        }

        $newGame->external_id    = $game->wp_id;
        $newGame->event_id       = $event?->id;
        $newGame->data           = @json_decode($game->data);
        $newGame->slug           = $game->slug;
        $newGame->title          = $game->title;
        $newGame->body           = $game->body;
        $newGame->home_team_id   = $homeTeam?->id;
        $newGame->away_team_id   = $awayTeam?->id;
        $newGame->status         = $status;
        $newGame->scheduled_at   = $game->scheduled_at;
        $newGame->created_at     = $game->created_at;
        $newGame->updated_at     = $game->updated_at;
        foreach (['home', 'away'] as $side) {
            $newGame->{$side . '_score'}    = $game->{$side . '_team_score'};
            $newGame->{$side . '_score_p1'} = $game->{$side . '_team_score_q1'};
            $newGame->{$side . '_score_p2'} = $game->{$side . '_team_score_q2'};
            $newGame->{$side . '_score_p3'} = $game->{$side . '_team_score_q3'};
            $newGame->{$side . '_score_p4'} = $game->{$side . '_team_score_q4'};
            $newGame->{$side . '_score_p5'} = $game->{$side . '_team_score_ot1'};
            $newGame->{$side . '_score_p6'} = $game->{$side . '_team_score_ot2'};
        }
        $newGame->save();

        // After this we need to sync the player scores for this game
        self::syncPlayerScores($newGame, $game);
    }

    public function syncTeamScores(Game $game, $legacyGame) {}

    public static function syncPlayerScores(Game $game, $legacyGame)
    {
        // Get the teams
        $teams = [
            'home' => $game->homeTeam,
            'away' => $game->awayTeam,
        ];

        foreach ($teams as $team) {
            foreach ($team->players as $player) {
                // First we need to get the stats for this player from the legacy game
                $legacyPlayerStats = DB::connection('mysql_legacy')->table('wp_zmsk_player_stats')->where('match_id', $legacyGame->id)->where('player_id', $player->external_id)->first();

                // Only continue if the player has stats for this game (sometime players don't play)
                if (! $legacyPlayerStats) {
                    continue;
                }

                // Create new stats
                $gamePlayer                       = new GamePlayer();
                $gamePlayer->event_id             = $game->event_id;
                $gamePlayer->game_id              = $game->id;
                $gamePlayer->player_id            = $player->id;
                $gamePlayer->team_id              = $team->id;
                $gamePlayer->score                = $legacyPlayerStats->points;
                $gamePlayer->three_points         = $legacyPlayerStats->three_pointers;
                $gamePlayer->three_points_made    = $legacyPlayerStats->three_pointers;
                $gamePlayer->rebounds             = $legacyPlayerStats->rebounds;
                $gamePlayer->assists              = $legacyPlayerStats->assists;
                $gamePlayer->blocks               = $legacyPlayerStats->blocks;
                $gamePlayer->turnovers            = $legacyPlayerStats->turnovers;

                $gamePlayer->save();
            }
        }
    }
}
