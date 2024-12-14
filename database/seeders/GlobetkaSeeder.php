<?php

namespace Database\Seeders;

use App\Models\Event;
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
        $globetka->players()->create(['name' => 'Neven Levačić',      'slug' => 'neven-levacic-glo',      'number' => 3,  'position' => 'pg', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Vedran Vurušić',     'slug' => 'vedran-vurusic-glo',     'number' => 45, 'position' => 'pf', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Manuel Novak',       'slug' => 'manuel-novak-glo',       'number' => 13, 'position' => 'pf', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Matija Novak',       'slug' => 'matija-novak-glo',       'number' => 12, 'position' => 'c',  'status' => 'active']);
        $globetka->players()->create(['name' => 'Danijel Podvezanec', 'slug' => 'danijel-podvezanec-glo', 'number' => 16, 'position' => 'sf', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Matija Terek',       'slug' => 'matija-terek-glo',       'number' => 3,  'position' => 'sg', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Daniel Radek',       'slug' => 'daniel-radek-glo',       'number' => 69, 'position' => 'pg', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Igor Šopar',         'slug' => 'igor-sopar-glo',         'number' => 6,  'position' => 'sg', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Tomislav Volf',      'slug' => 'tomislav-volf-glo',      'number' => 4,  'position' => 'pf', 'status' => 'active']);
        $globetka->players()->create(['name' => 'Davor Novak',        'slug' => 'davor-novak-glo',        'number' => 2,  'position' => 'sg', 'status' => 'active']);

        // Add more teams
        $varteks = $event->teams()->create([
            'title'       => 'KK Varteks',
            'slug'        => 'varteks',
            'short_title' => 'VART',
            'status'      => 'active',
        ]);

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
    }
}
