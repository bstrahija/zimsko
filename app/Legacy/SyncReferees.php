<?php

namespace App\Legacy;

use App\Jobs\AddMediaToModel;
use App\Models\Game;
use App\Models\Official;
use Illuminate\Support\Facades\DB;

class SyncReferees
{
    public static function run($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_referees')->get()
            ->each(
                function ($referee) use ($media) {
                    // Check if referee already exists
                    if (Official::where('external_id', $referee->wp_id)->where('type', 'referee')->first()) return;

                    $names      = explode(' ', $referee->name);
                    $firstName  = $names[0];
                    $lastName   = isset($names[1]) ? $names[1] : '';

                    // The slug
                    $slug = $referee->slug;
                    if ($slug === 'matija-terek' && $referee->name === 'Vedran Biševac') $slug = 'vedran-bisevac';

                    $newReferee              = new \App\Models\Official();
                    $newReferee->external_id = $referee->wp_id;
                    $newReferee->first_name  = $firstName;
                    $newReferee->last_name   = $lastName;
                    $newReferee->slug        = $referee->slug;
                    $newReferee->body        = $referee->body;
                    $newReferee->status      = $referee->status;
                    $newReferee->type        = 'referee';
                    // $newReferee->data        = $referee->data ? @json_decode($referee->data) : '{}';
                    $newReferee->created_at  = $referee->created_at;
                    $newReferee->updated_at  = $referee->updated_at;
                    $newReferee->save();

                    // Attach the referee to games
                    $legacyGames = DB::connection('mysql_legacy')->table('wp_zmsk_match_referee')->where('referee_id', $newReferee->external_id)->get();
                    if ($legacyGames && $legacyGames->count()) {
                        foreach ($legacyGames as $legacyGame) {
                            $game = Game::with('event')->where('external_id', $legacyGame->match_id)->first();

                            if ($game) {
                                $newReferee->games()->attach($game, ['created_at' => $game->created_at, 'updated_at' => $game->updated_at]);
                                $newReferee->events()->attach($game->event, ['created_at' => $game->event->created_at, 'updated_at' => $game->event->updated_at]);
                            }
                        }
                    }

                    // Also add media if needed
                    if ($media) {
                        // We also need to assign the media files
                        $data = @json_decode($referee->data);

                        try {
                            if ($data && isset($data->photo) && $data->photo) {
                                AddMediaToModel::dispatch($newReferee, $data->photo, 'photos');
                                // $newReferee->addMediaFromUrl($data->photo)->toMediaCollection('photos');
                            }
                        } catch (\Exception $e) {
                            dump($e->getMessage());
                        }
                    }
                }
            );
    }
}
