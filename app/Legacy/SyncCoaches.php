<?php

namespace App\Legacy;

use App\Jobs\AddMediaToModel;
use App\Models\Coach;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class SyncCoaches
{
    public static function run($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_coaches')->get()
            ->each(
                function ($coach) use ($media) {
                    // Check if referee already exists
                    if (Coach::where('external_id', $coach->wp_id)->first()) return;

                    $names      = explode(' ', $coach->name);
                    $firstName  = $names[0];
                    $lastName   = isset($names[1]) ? $names[1] : '';

                    $newCoach              = new \App\Models\Coach();
                    $newCoach->external_id = $coach->wp_id;
                    $newCoach->first_name  = $firstName;
                    $newCoach->last_name   = $lastName;
                    $newCoach->slug        = $coach->slug;
                    $newCoach->body        = $coach->body;
                    $newCoach->status      = $coach->status;
                    $newCoach->data        = @json_decode($coach->data);
                    $newCoach->created_at  = $coach->created_at;
                    $newCoach->updated_at  = $coach->updated_at;
                    $newCoach->save();

                    // We also need to assign the team
                    $legacyTeams = DB::connection('mysql_legacy')->table('wp_zmsk_coach_team')->where('coach_id', $newCoach->external_id)->get();
                    if ($legacyTeams && $legacyTeams->count()) {
                        $team = Team::where('external_id', $legacyTeams[0]->team_id)->first();
                        $newCoach->teams()->attach($team);
                    }

                    // Also add media if needed
                    if ($media) {
                        // We also need to assign the media files
                        $data = @json_decode($coach->data);

                        try {
                            if ($data && isset($data->photo) && $data->photo) {
                                AddMediaToModel::dispatch($newCoach, $data->photo, 'photos');
                                // $newCoach->addMediaFromUrl($data->photo)->toMediaCollection('photos');
                            }
                        } catch (\Exception $e) {
                            dump($e->getMessage());
                        }
                    }
                }
            );
    }
}
