<?php

namespace App\Legacy;

use Illuminate\Support\Facades\DB;

class SyncPlayers
{
    public static function run($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_players')->get()
            ->each(function ($player) use ($media) {
                $newPlayer              = new \App\Models\Player();
                $newPlayer->external_id = $player->wp_id;
                $newPlayer->name        = $player->name;
                $newPlayer->slug        = $player->slug;
                $newPlayer->body        = $player->body;
                $newPlayer->position    = $player->position;
                $newPlayer->number      = $player->number;
                $newPlayer->birthday    = $player->birthday;
                $newPlayer->status      = $player->status;
                $newPlayer->data        = @json_decode($player->data);
                $newPlayer->created_at  = $player->created_at;
                $newPlayer->updated_at  = $player->updated_at;
                $newPlayer->save();

                // We also need to assign the team
                $legacyTeams = DB::connection('mysql_legacy')->table('wp_zmsk_player_team')->where('player_id', $newPlayer->external_id)->get();

                $legacyTeams->each(function ($legacyTeam) use ($newPlayer) {
                    $team = \App\Models\Team::where('external_id', $legacyTeam->team_id)->first();
                    $newPlayer->teams()->attach($team);
                });


                // $team = \App\Models\Team::where('external_id', $player->team_id)->first();
                // $newPlayer->team_id = $team->id;
                // $newPlayer->save();

                if ($media) {
                    // We also need to assign the media files
                    $data = @json_decode($player->data);

                    try {
                        if ($data && isset($data->photo) && $data->photo) $newPlayer->addMediaFromUrl($data->photo)->toMediaCollection('photos');
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }
            });
    }
}
