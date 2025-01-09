<?php

namespace App\Legacy;

use App\Jobs\AddMediaToModel;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class SyncTeams
{
    public static function run($media = true)
    {
        DB::connection('mysql_legacy')->table('wp_zmsk_teams')->get()
            ->each(function ($team) use ($media) {
                // Check if team already exists
                if (Team::where('external_id', $team->wp_id)->first()) return;

                // We also need to generate a short title
                $shortTitle = 'KK';
                if ($team->slug === 'agrow-basket')         $shortTitle = 'AGWB';
                if ($team->slug === 'pozoji')               $shortTitle = 'POZJ';
                if ($team->slug === 'kk-rudar-veterani')    $shortTitle = 'KKRD';
                if ($team->slug === 'agm-basket')           $shortTitle = 'AGMB';
                if ($team->slug === 'stoperi-fiskal')       $shortTitle = 'STFŠ';
                if ($team->slug === 'bc-nord-ing')          $shortTitle = 'BCNI';
                if ($team->slug === 'pilipinas')            $shortTitle = 'PILP';
                if ($team->slug === 'ppc')                  $shortTitle = 'PPČ';
                if ($team->slug === 'euro-opus')            $shortTitle = 'EURO';
                if ($team->slug === 'parks')                $shortTitle = 'PARKS';
                if ($team->slug === 'hespo-medina-skrinja') $shortTitle = 'HMEŠ';
                if ($team->slug === 'cfbl')                 $shortTitle = 'CFBL';
                if ($team->slug === 'shpitza')              $shortTitle = 'SHPZ';
                if ($team->slug === 'basket-case-2019')     $shortTitle = 'BCAS';

                $newTeam              = new \App\Models\Team();
                $newTeam->external_id = $team->wp_id;
                $newTeam->title       = $team->title;
                $newTeam->short_title = $shortTitle;
                $newTeam->slug        = $team->slug;
                $newTeam->body        = $team->body;
                $newTeam->data        = @json_decode($team->data);
                $newTeam->created_at  = $team->created_at;
                $newTeam->updated_at  = $team->updated_at;
                $newTeam->save();

                // Also assign to events (hardcoded)
                if ($team->slug === 'agrow-basket') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                } elseif ($team->slug === 'pozoji') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                } elseif ($team->slug === 'kk-rudar-veterani') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                } elseif ($team->slug === 'agm-basket') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2021')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2020')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                } elseif ($team->slug === 'stoperi-fiskal') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2021')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2020')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                } elseif ($team->slug === 'bc-nord-ing') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2021')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2020')->first()->id);
                } elseif ($team->slug === 'pilipinas') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                } elseif ($team->slug === 'ppc') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2021')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2020')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                } elseif ($team->slug === 'euro-opus') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                } elseif ($team->slug === 'parks') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2025')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2024')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2021')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2020')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                } elseif ($team->slug === 'hespo-medina-skrinja') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2022')->first()->id);
                } elseif ($team->slug === 'cfbl') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2023')->first()->id);
                } elseif ($team->slug === 'shpitza') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                } elseif ($team->slug === 'basket-case-2019') {
                    $newTeam->events()->attach(Event::where('slug', 'zimsko-2019')->first()->id);
                }

                if ($media) {
                    // We also need to assign the media files
                    $data = @json_decode($team->data);

                    try {
                        if ($data && isset($data->photo) && $data->photo) {
                            AddMediaToModel::dispatch($newTeam, $data->photo, 'photos');
                            //defer(fn() => $newTeam->addMediaFromUrl($data->photo)->toMediaCollection('photos'));
                        }
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                    try {
                        if ($data && isset($data->logo) && $data->logo) {
                            AddMediaToModel::dispatch($newTeam, $data->logo, 'logos');
                            //defer(fn() => $newTeam->addMediaFromUrl($data->logo)->toMediaCollection('logos'));
                        }
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                    try {
                        if ($data && isset($data->background) && $data->background) {
                            AddMediaToModel::dispatch($newTeam, $data->background, 'backgrounds');
                            //defer(fn() => $newTeam->addMediaFromUrl($data->background)->toMediaCollection('backgrounds'));
                        }
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                }
            });
    }
}
