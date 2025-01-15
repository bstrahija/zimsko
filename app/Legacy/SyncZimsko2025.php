<?php

namespace App\Legacy;

use App\Jobs\AddMediaToModel;
use App\Models\Event;
use App\Models\Game;
use App\Models\Round;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SyncZimsko2025
{
    protected static $gameData = [
        // 1. kolo
        ['round' => '1. kolo', 'home_team' => "parks",       'away_team' => "pilipinas", 'scheduled_at' => '2024-02-02 08:15:00'],
        ['round' => '1. kolo', 'home_team' => "euro-opus",   'away_team' => "agm",       'scheduled_at' => '2024-02-02 09:30:00'],
        ['round' => '1. kolo', 'home_team' => "agrow",       'away_team' => "pozoji",    'scheduled_at' => '2024-02-02 10:45:00'],
        ['round' => '1. kolo', 'home_team' => "bc-nord-ing", 'away_team' => "rudar",     'scheduled_at' => '2024-02-02 12:00:00'],
        ['round' => '1. kolo', 'home_team' => "ppc",         'away_team' => "stoperi",   'scheduled_at' => '2024-02-02 13:15:00'],

        // 2. kolo
        ['round' => '2. kolo', 'home_team' => "stoperi",   'away_team' => "agrow",       'scheduled_at' => '2024-02-09 08:15:00'],
        ['round' => '2. kolo', 'home_team' => "ppc",       'away_team' => "agm",         'scheduled_at' => '2024-02-09 09:30:00'],
        ['round' => '2. kolo', 'home_team' => "rudar",     'away_team' => "euro-opus",   'scheduled_at' => '2024-02-09 10:45:00'],
        ['round' => '2. kolo', 'home_team' => "pilipinas", 'away_team' => "bc-nord-ing", 'scheduled_at' => '2024-02-09 12:00:00'],
        ['round' => '2. kolo', 'home_team' => "pozoji",    'away_team' => "parks",       'scheduled_at' => '2024-02-09 13:15:00'],

        // 3. kolo
        ['round' => '3. kolo', 'home_team' => "bc-nord-ing", 'away_team' => "pozoji",    'scheduled_at' => '2024-02-16 08:15:00'],
        ['round' => '3. kolo', 'home_team' => "euro-opus",   'away_team' => "pilipinas", 'scheduled_at' => '2024-02-16 09:30:00'],
        ['round' => '3. kolo', 'home_team' => "agm",         'away_team' => "rudar",     'scheduled_at' => '2024-02-16 10:45:00'],
        ['round' => '3. kolo', 'home_team' => "parks",       'away_team' => "stoperi",   'scheduled_at' => '2024-02-16 12:00:00'],
        ['round' => '3. kolo', 'home_team' => "agrow",       'away_team' => "ppc",       'scheduled_at' => '2024-02-16 13:15:00'],

        // 4. kolo
        ['round' => '4. kolo', 'home_team' => "agm",       'away_team' => "agrow",       'scheduled_at' => '2024-02-23 08:15:00'],
        ['round' => '4. kolo', 'home_team' => "stoperi",   'away_team' => "bc-nord-ing", 'scheduled_at' => '2024-02-23 09:30:00'],
        ['round' => '4. kolo', 'home_team' => "ppc",       'away_team' => "parks",       'scheduled_at' => '2024-02-23 10:45:00'],
        ['round' => '4. kolo', 'home_team' => "pilipinas", 'away_team' => "rudar",       'scheduled_at' => '2024-02-23 12:00:00'],
        ['round' => '4. kolo', 'home_team' => "pozoji",    'away_team' => "euro-opus",   'scheduled_at' => '2024-02-23 13:15:00'],

        // 5. kolo
        ['round' => '5. kolo', 'home_team' => "euro-opus",   'away_team' => "stoperi", 'scheduled_at' => '2024-03-02 08:15:00'],
        ['round' => '5. kolo', 'home_team' => "pilipinas",   'away_team' => "agm",     'scheduled_at' => '2024-03-02 09:30:00'],
        ['round' => '5. kolo', 'home_team' => "rudar",       'away_team' => "pozoji",  'scheduled_at' => '2024-03-02 10:45:00'],
        ['round' => '5. kolo', 'home_team' => "parks",       'away_team' => "agrow",   'scheduled_at' => '2024-03-02 12:00:00'],
        ['round' => '5. kolo', 'home_team' => "bc-nord-ing", 'away_team' => "ppc",     'scheduled_at' => '2024-03-02 13:15:00'],

        // 6. kolo
        ['round' => '6. kolo', 'home_team' => "parks",   'away_team' => "agm",         'scheduled_at' => '2024-03-09 08:15:00'],
        ['round' => '6. kolo', 'home_team' => "pozoji",  'away_team' => "pilipinas",   'scheduled_at' => '2024-03-09 09:30:00'],
        ['round' => '6. kolo', 'home_team' => "stoperi", 'away_team' => "rudar",       'scheduled_at' => '2024-03-09 10:45:00'],
        ['round' => '6. kolo', 'home_team' => "ppc",     'away_team' => "euro-opus",   'scheduled_at' => '2024-03-09 12:00:00'],
        ['round' => '6. kolo', 'home_team' => "agrow",   'away_team' => "bc-nord-ing", 'scheduled_at' => '2024-03-09 13:15:00'],

        // 7. kolo
        ['round' => '7. kolo', 'home_team' => "rudar",       'away_team' => "ppc",     'scheduled_at' => '2024-03-16 08:15:00'],
        ['round' => '7. kolo', 'home_team' => "pilipinas",   'away_team' => "stoperi", 'scheduled_at' => '2024-03-16 09:30:00'],
        ['round' => '7. kolo', 'home_team' => "agm",         'away_team' => "pozoji",  'scheduled_at' => '2024-03-16 10:45:00'],
        ['round' => '7. kolo', 'home_team' => "bc-nord-ing", 'away_team' => "parks",   'scheduled_at' => '2024-03-16 12:00:00'],
        ['round' => '7. kolo', 'home_team' => "euro-opus",   'away_team' => "agrow",   'scheduled_at' => '2024-03-16 13:15:00'],

        // 8. kolo
        ['round' => '8. kolo', 'home_team' => "ppc",      'away_team' => "pilipinas",   'scheduled_at' => '2024-03-23 08:15:00'],
        ['round' => '8. kolo', 'home_team' => "parks",    'away_team' => "euro-opus",   'scheduled_at' => '2024-03-23 09:30:00'],
        ['round' => '8. kolo', 'home_team' => "agm",      'away_team' => "bc-nord-ing", 'scheduled_at' => '2024-03-23 10:45:00'],
        ['round' => '8. kolo', 'home_team' => "stoperi", 'away_team' => "pozoji",       'scheduled_at' => '2024-03-23 12:00:00'],
        ['round' => '8. kolo', 'home_team' => "agrow",   'away_team' => "rudar",        'scheduled_at' => '2024-03-23 13:15:00'],
    ];

    public static function run($media = true)
    {
        // First get the event
        $event = Event::where('slug', 'zimsko-2025')->first();

        if ($event) {
            foreach (self::$gameData as $item) {
                // Let's get the teams
                $homeTeam = Team::where('slug', 'LIKE', '%' . $item['home_team'] . '%')->first();
                $awayTeam = Team::where('slug', 'LIKE', '%' . $item['away_team'] . '%')->first();

                // Then the round
                $round = Round::where('title', 'LIKE', $item['round'] . '%')->first();

                if ($homeTeam && $awayTeam && $round) {
                    // Let's generate the title and slug
                    $title = $round->title . ' | ' . $homeTeam->title . ' - ' . $awayTeam->title;
                    $slug  = Str::slug($event->title . '-' . $title);

                    // And then check if we already have the game
                    $exists = Game::where([
                        'event_id' => $event->id,
                        'round_id' => $round->id,
                        'home_team_id' => $homeTeam->id,
                        'away_team_id' => $awayTeam->id,
                    ])->first();

                    if (! $exists) {
                        Game::query()->create([
                            'title'        => $title,
                            'slug'         => $slug,
                            'event_id'     => $event->id,
                            'round_id'     => $round->id,
                            'home_team_id' => $homeTeam->id,
                            'away_team_id' => $awayTeam->id,
                            'scheduled_at' => $item['scheduled_at'],
                        ]);
                    } else {
                        dump("Game exists");
                    }
                } else {
                    if (! $homeTeam) dump("Home team '{$item['home_team']}' doesnt exist.");
                    if (! $awayTeam) dump("Away team '{$item['away_team']}' doesnt exist.");
                    if (! $round) dump("Round '{$item['round']}' doesnt exist.");
                }
            }
        }
    }
}
