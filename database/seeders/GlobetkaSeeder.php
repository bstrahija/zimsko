<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\GameTeam;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobetkaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add the event
        $event = Event::create([
            'title'        => '3. Liga Sjever 2024/2025',
            'slug'         => '3-liga-sjever-2024',
            'status'       => 'active',
            'scheduled_at' => '2024-10-25 19:00:00',
        ]);

        // First let's create the Globetka team
        $globetka = $event->teams()->create([
            'title'       => 'Globetka Čakovec',
            'slug'        => 'globetka',
            'short_title' => 'GLČK',
            'status'      => 'active',
        ]);

        // Now we also need some players
        $globetka->players()->create(['first_name' => 'Neven',    'last_name' => 'Levačić',    'slug' => 'neven-levacic-glo',      'status' => 'active'], ['number' => 3,  'position' => 'pg']);
        $globetka->players()->create(['first_name' => 'Vedran',   'last_name' => 'Vurušić',    'slug' => 'vedran-vurusic-glo',     'status' => 'active'], ['number' => 45, 'position' => 'pf']);
        $globetka->players()->create(['first_name' => 'Manuel',   'last_name' => 'Novak',      'slug' => 'manuel-novak-glo',       'status' => 'active'], ['number' => 13, 'position' => 'pf']);
        $globetka->players()->create(['first_name' => 'Matija',   'last_name' => 'Novak',      'slug' => 'matija-novak-glo',       'status' => 'active'], ['number' => 12, 'position' => 'c']);
        $globetka->players()->create(['first_name' => 'Danijel',  'last_name' => 'Podvezanec', 'slug' => 'danijel-podvezanec-glo', 'status' => 'active'], ['number' => 16, 'position' => 'sf']);
        $globetka->players()->create(['first_name' => 'Matija',   'last_name' => 'Terek',      'slug' => 'matija-terek-glo',       'status' => 'active'], ['number' => 3,  'position' => 'sg']);
        $globetka->players()->create(['first_name' => 'Daniel',   'last_name' => 'Radek',      'slug' => 'daniel-radek-glo',       'status' => 'active'], ['number' => 69, 'position' => 'pg']);
        $globetka->players()->create(['first_name' => 'Igor',     'last_name' => 'Šopar',      'slug' => 'igor-sopar-glo',         'status' => 'active'], ['number' => 6,  'position' => 'sg']);
        $globetka->players()->create(['first_name' => 'Tomislav', 'last_name' => 'Volf',       'slug' => 'tomislav-volf-glo',      'status' => 'active'], ['number' => 4,  'position' => 'pf']);
        $globetka->players()->create(['first_name' => 'Davor',    'last_name' => 'Novak',      'slug' => 'davor-novak-glo',        'status' => 'active'], ['number' => 2,  'position' => 'sg']);

        // Add more teams
        $varteks = $event->teams()->create([
            'title'       => 'KK Varteks',
            'slug'        => 'varteks',
            'short_title' => 'VART',
            'status'      => 'active',
        ]);
        $varteks->players()->create(['first_name' => 'J.',    'last_name' => 'Ostojić', 'slug' => 'j-ostojic-glo',    'status' => 'active'], ['number' => 1,  'position' => 'pg']);
        $varteks->players()->create(['first_name' => 'M.',    'last_name' => 'Cesarec', 'slug' => 'm-cesarec-glo',    'status' => 'active'], ['number' => 2,  'position' => 'sg']);
        $varteks->players()->create(['first_name' => 'N.',    'last_name' => 'Kos',     'slug' => 'n-kos-glo',        'status' => 'active'], ['number' => 3,  'position' => 'pf']);
        $varteks->players()->create(['first_name' => 'M.',    'last_name' => 'Bađun',   'slug' => 'm-badjun-glo',     'status' => 'active'], ['number' => 4,  'position' => 'sg']);
        $varteks->players()->create(['first_name' => 'D.',    'last_name' => 'Cesarec', 'slug' => 'd-cesarec-glo',    'status' => 'active'], ['number' => 5,  'position' => 'sg']);
        $varteks->players()->create(['first_name' => 'Davor', 'last_name' => 'Ostoja',  'slug' => 'davor-ostoja-glo', 'status' => 'active'], ['number' => 6,  'position' => 'sg']);
        $varteks->players()->create(['first_name' => 'K.',    'last_name' => 'Rakonić', 'slug' => 'k-rakonic-glo',    'status' => 'active'], ['number' => 7,  'position' => 'sg']);
        $varteks->players()->create(['first_name' => 'I.',    'last_name' => 'Marić',   'slug' => 'i-maric-glo',      'status' => 'active'], ['number' => 8,  'position' => 'sg']);

        $nedelisce = $event->teams()->create([
            'title'       => 'KK Nedelisce',
            'slug'        => 'nedelisce',
            'short_title' => 'NED',
            'status'      => 'active',
        ]);

        $donjiKraljevec = $event->teams()->create([
            'title'       => 'Donji Kraljevec',
            'slug'        => 'donji-kraljevec',
            'short_title' => 'DKR',
            'status'      => 'active',
        ]);

        $vinica = $event->teams()->create([
            'title'       => 'Vinica',
            'slug'        => 'vinica',
            'short_title' => 'KKVN',
            'status'      => 'active',
        ]);

        $kotoriba = $event->teams()->create([
            'title'       => 'KK Kotoriba',
            'slug'        => 'kotoriba',
            'short_title' => 'KKKT',
            'status'      => 'active',
        ]);

        $rudar = $event->teams()->create([
            'title'       => 'KK Rudar',
            'slug'        => 'rudar',
            'short_title' => 'KKRD',
            'status'      => 'active',
        ]);

        $dubravcan = $event->teams()->create([
            'title'       => 'KK Dubravčan',
            'slug'        => 'dubravcan',
            'short_title' => 'KKDB',
            'status'      => 'active',
        ]);

        // // Now we add some games
        // $game = $globetka->homeGames()->create([
        //     'event_id'     => $event->id,
        //     'title'        => '5. kolo - Globetka Čakovec - KK Varteks',
        //     'away_team_id' => $varteks->id,
        //     'scheduled_at' => '2024-12-15 19:00:00',
        // ]);
        // GameTeam::create(['team_id' => $game->home_team_id, 'game_id' => $game->id, 'score' => 43, 'score_p1' => 1, 'score_p2' => 2]);
        // GameTeam::create(['team_id' => $game->away_team_id, 'game_id' => $game->id, 'score' => 66, 'score_p1' => 3, 'score_p2' => 4]);
        // // $game = $varteks->homeGames()->create([
        // //     'event_id'     => $event->id,
        // //     'title'        => '10. kolo - KK Varteks - Globetka Čakovec',
        // //     'away_team_id' => $globetka->id,
        // //     'scheduled_at' => '2025-03-15 19:00:00',
        // // ]);
        // // GameTeam::create(['team_id' => $game->home_team_id, 'game_id' => $game->id, 'score' => 23, 'score_p1' => 5, 'score_p2' => 6]);
        // // GameTeam::create(['team_id' => $game->away_team_id, 'game_id' => $game->id, 'score' => 46, 'score_p1' => 7, 'score_p2' => 8]);
        // // $game = $nedelisce->homeGames()->create([
        // //     'event_id'     => $event->id,
        // //     'title'        => '4. kolo - KK Varteks - Globetka Čakovec',
        // //     'away_team_id' => $globetka->id,
        // //     'scheduled_at' => '2025-02-15 19:00:00',
        // // ]);
        // // GameTeam::create(['team_id' => $game->home_team_id, 'game_id' => $game->id, 'score' => 123, 'score_p1' => 25, 'score_p2' => 26]);
        // // GameTeam::create(['team_id' => $game->away_team_id, 'game_id' => $game->id, 'score' => 146, 'score_p1' => 27, 'score_p2' => 28]);
    }
}
