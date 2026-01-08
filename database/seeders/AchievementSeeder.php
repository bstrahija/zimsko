<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First clear out the table
        \DB::table('achievements')->truncate();

        // Teams
        // Agrow - 1
        // Pozoji - 2
        // Rudar - 3
        // Agm - 4
        // Stoperi - 5
        // Basket Case - 6
        // Pilipinas - 7
        // PPC - 8
        // Euro opus - 9
        // Parks - 10
        // Hespo - 11
        // CFBL - 12
        // Spitza - 13
        // BC OLD - 14

        // =============================

        // 2025 - Placement
        Achievement::create(['type' => 'champion',  'event_id' => 8, 'team_id' => 8,  'slug' => 'champion-zimsko-2025']);
        Achievement::create(['type' => '2nd-place', 'event_id' => 8, 'team_id' => 1,  'slug' => '2nd-place-zimsko-2025']);
        Achievement::create(['type' => '3rd-place', 'event_id' => 8, 'team_id' => 10, 'slug' => '3rd-place-zimsko-2025']);
        Achievement::create(['type' => '4th-place', 'event_id' => 8, 'team_id' => 6, 'slug' => '4th-place-zimsko-2025']);
        Achievement::create(['type' => '5th-place', 'event_id' => 8, 'team_id' => 5, 'slug' => '5th-place-zimsko-2025']);
        Achievement::create(['type' => '6th-place', 'event_id' => 8, 'team_id' => 2, 'slug' => '6th-place-zimsko-2025']);
        Achievement::create(['type' => '7th-place', 'event_id' => 8, 'team_id' => 3, 'slug' => '7th-place-zimsko-2025']);
        Achievement::create(['type' => '8th-place', 'event_id' => 8, 'team_id' => 4, 'slug' => '8th-place-zimsko-2025']);
        Achievement::create(['type' => '9th-place', 'event_id' => 8, 'team_id' => 9, 'slug' => '9th-place-zimsko-2025']);
        Achievement::create(['type' => '10th-place', 'event_id' => 8, 'team_id' => 7, 'slug' => '10th-place-zimsko-2025']);

        // 2025 - Players
        Achievement::create(['type' => 'mvp',             'event_id' => 8, 'player_id' => 109, 'team_id' => 8,  'slug' => 'mvp-zimsko-2025']);
        Achievement::create(['type' => 'top-3pt',         'event_id' => 8, 'player_id' => 11,  'team_id' => 1,  'slug' => 'top-3pt-zimsko-2025']);
        Achievement::create(['type' => 'top-score',       'event_id' => 8, 'player_id' => 109, 'team_id' => 8,  'slug' => 'top-score-zimsko-2025']);
        Achievement::create(['type' => 'top-assists',     'event_id' => 8, 'player_id' => 106, 'team_id' => 8,  'slug' => 'top-assists-zimsko-2025']);
        Achievement::create(['type' => 'top-blocks',      'event_id' => 8, 'player_id' => 58,  'team_id' => 4,  'slug' => 'top-blocks-zimsko-2025']);
        Achievement::create(['type' => 'top-steals',      'event_id' => 8, 'player_id' => 56,  'team_id' => 4,  'slug' => 'top-steals-zimsko-2025']);
        Achievement::create(['type' => 'top-rebounds',    'event_id' => 8, 'player_id' => 126, 'team_id' => 5,  'slug' => 'top-rebounds-zimsko-2025']);
        Achievement::create(['type' => 'top-fouls',       'event_id' => 8, 'player_id' => 129, 'team_id' => 10, 'slug' => 'top-fouls-zimsko-2025']);
        Achievement::create(['type' => 'top-turnovers',   'event_id' => 8, 'player_id' => 126, 'team_id' => 5,  'slug' => 'top-turnovers-zimsko-2025']);
        Achievement::create(['type' => 'top-efficiency',  'event_id' => 8, 'player_id' => 126, 'team_id' => 5,  'slug' => 'top-efficiency-zimsko-2025']);
        Achievement::create(['type' => 'top-free-throws', 'event_id' => 8, 'player_id' => 76,  'team_id' => 6,  'slug' => 'top-free-throws-zimsko-2025']);
        Achievement::create(['type' => 'top-five',        'event_id' => 8, 'player_id' => 109, 'team_id' => 8,  'slug' => 'top-five-zimsko-2025']);
        Achievement::create(['type' => 'top-five',        'event_id' => 8, 'player_id' => 126, 'team_id' => 5, 'slug' => 'top-five-zimsko-2025']);
        Achievement::create(['type' => 'top-five',        'event_id' => 8, 'player_id' => 106, 'team_id' => 8,  'slug' => 'top-five-zimsko-2025']);
        Achievement::create(['type' => 'top-five',        'event_id' => 8, 'player_id' => 11,  'team_id' => 1,  'slug' => 'top-five-zimsko-2025']);
        Achievement::create(['type' => 'top-five',        'event_id' => 8, 'player_id' => 134, 'team_id' => 10, 'slug' => 'top-five-zimsko-2025']);

        // 2025 - Teams
        Achievement::create(['type' => 'team-top-score',       'event_id' => 8, 'team_id' => 1, 'slug' => 'team-top-score-zimsko-2025']);
        Achievement::create(['type' => 'team-top-3pt',         'event_id' => 8, 'team_id' => 8, 'slug' => 'team-top-3pt-zimsko-2025']);
        Achievement::create(['type' => 'team-top-assists',     'event_id' => 8, 'team_id' => 8, 'slug' => 'team-top-assists-zimsko-2025']);
        Achievement::create(['type' => 'team-top-blocks',      'event_id' => 8, 'team_id' => 8, 'slug' => 'team-top-blocks-zimsko-2025']);
        Achievement::create(['type' => 'team-top-steals',      'event_id' => 8, 'team_id' => 8, 'slug' => 'team-top-steals-zimsko-2025']);
        Achievement::create(['type' => 'team-top-rebounds',    'event_id' => 8, 'team_id' => 3, 'slug' => 'team-top-rebounds-zimsko-2025']);
        Achievement::create(['type' => 'team-top-fouls',       'event_id' => 8, 'team_id' => 10, 'slug' => 'team-top-fouls-zimsko-2025']);
        Achievement::create(['type' => 'team-top-turnovers',   'event_id' => 8, 'team_id' => 5, 'slug' => 'team-top-turnovers-zimsko-2025']);
        Achievement::create(['type' => 'team-top-efficiency',  'event_id' => 8, 'team_id' => 1, 'slug' => 'team-top-efficiency-zimsko-2025']);
        Achievement::create(['type' => 'team-top-free-throws', 'event_id' => 8, 'team_id' => 5, 'slug' => 'team-top-free-throws-zimsko-2025']);

        // =============================

        // 2024 - Teams
        Achievement::create(['type' => 'champion',   'event_id' => 2, 'team_id' => 10, 'slug' => 'champion-zimsko-2024']);
        Achievement::create(['type' => '2nd-place',  'event_id' => 2, 'team_id' => 6,  'slug' => '2nd-place-zimsko-2024']);
        Achievement::create(['type' => '3rd-place',  'event_id' => 2, 'team_id' => 1,  'slug' => '3rd-place-zimsko-2024']);
        Achievement::create(['type' => '4th-place',  'event_id' => 2, 'team_id' => 2,  'slug' => '4th-place-zimsko-2024']);
        Achievement::create(['type' => '5th-place',  'event_id' => 2, 'team_id' => 8,  'slug' => '5th-place-zimsko-2024']);
        Achievement::create(['type' => '6th-place',  'event_id' => 2, 'team_id' => 3,  'slug' => '6th-place-zimsko-2024']);
        Achievement::create(['type' => '7th-place',  'event_id' => 2, 'team_id' => 5,  'slug' => '7th-place-zimsko-2024']);
        Achievement::create(['type' => '8th-place',  'event_id' => 2, 'team_id' => 4,  'slug' => '8th-place-zimsko-2024']);
        Achievement::create(['type' => '9th-place',  'event_id' => 2, 'team_id' => 7,  'slug' => '9th-place-zimsko-2024']);
        Achievement::create(['type' => '10th-place', 'event_id' => 2, 'team_id' => 9,  'slug' => '10th-place-zimsko-2024']);

        // 2024 - Players
        Achievement::create(['type' => 'mvp-f4',          'event_id' => 2, 'player_id' => 127, 'team_id' => 10, 'slug' => 'mvp-zimsko-2024']);
        Achievement::create(['type' => 'top-score',       'event_id' => 2, 'player_id' => 11,  'team_id' => 1,   'slug' => 'top-score-zimsko-2024']);
        Achievement::create(['type' => 'oldest-player',   'event_id' => 2, 'player_id' => 66,  'team_id' => 5,   'slug' => 'oldest-player-zimsko-2024']);
        // Achievement::create(['type' => 'youngest-player', 'event_id' => 2, 'player_id' => 0, 'team_id' => 8,  'slug' => 'youngest-player-2024']);
        Achievement::create(['type' => 'top-five',        'event_id' => 2, 'player_id' => 11,  'team_id' => 1,  'slug' => 'top-five-zimsko-2024']);
        Achievement::create(['type' => 'top-five',        'event_id' => 2, 'player_id' => 126, 'team_id' => 10, 'slug' => 'top-five-zimsko-2024']);
        Achievement::create(['type' => 'top-five',        'event_id' => 2, 'player_id' => 82,  'team_id' => 6,  'slug' => 'top-five-zimsko-2024']);
        Achievement::create(['type' => 'top-five',        'event_id' => 2, 'player_id' => 31,  'team_id' => 2,  'slug' => 'top-five-zimsko-2024']);
        Achievement::create(['type' => 'top-five',        'event_id' => 2, 'player_id' => 120, 'team_id' => 7,  'slug' => 'top-five-zimsko-2024']);

        // =============================

        // 2023 - Teams
        Achievement::create(['type' => 'champion',   'event_id' => 3, 'team_id' => 10, 'slug' => 'champion-zimsko-2023']);
        Achievement::create(['type' => '2nd-place',  'event_id' => 3, 'team_id' => 1,  'slug' => '2nd-place-zimsko-2023']);
        Achievement::create(['type' => '3rd-place',  'event_id' => 3, 'team_id' => 8,  'slug' => '3rd-place-zimsko-2023']);
        Achievement::create(['type' => '4th-place',  'event_id' => 3, 'team_id' => 2,  'slug' => '4th-place-zimsko-2023']);
        Achievement::create(['type' => '5th-place',  'event_id' => 3, 'team_id' => 6,  'slug' => '5th-place-zimsko-2023']);
        Achievement::create(['type' => '6th-place',  'event_id' => 3, 'team_id' => 11, 'slug' => '6th-place-zimsko-2023']);
        Achievement::create(['type' => '7th-place',  'event_id' => 3, 'team_id' => 4,  'slug' => '7th-place-zimsko-2023']);
        Achievement::create(['type' => '8th-place',  'event_id' => 3, 'team_id' => 5,  'slug' => '8th-place-zimsko-2023']);
        Achievement::create(['type' => '9th-place',  'event_id' => 3, 'team_id' => 7,  'slug' => '9th-place-zimsko-2023']);
        Achievement::create(['type' => '10th-place', 'event_id' => 3, 'team_id' => 12, 'slug' => '10th-place-zimsko-2023']);

        // 2023 - Players
        Achievement::create(['type' => 'mvp',           'event_id' => 3, 'player_id' => 123, 'team_id' => 10,  'slug' => 'mvp-zimsko-2023']);
        Achievement::create(['type' => 'oldest-player', 'event_id' => 3, 'player_id' => 66,  'team_id' => 5,   'slug' => 'oldest-player-zimsko-2023']);
        Achievement::create(['type' => 'top-score',     'event_id' => 3, 'player_id' => 11,  'team_id' => 1,   'slug' => 'top-score-zimsko-2023']);

        // =============================

        // 2022 - Teams
        Achievement::create(['type' => 'champion',   'event_id' => 4, 'team_id' => 1,  'slug' => 'champion-zimsko-2022']);
        Achievement::create(['type' => '2nd-place',  'event_id' => 4, 'team_id' => 8,  'slug' => '2nd-place-zimsko-2022']);
        Achievement::create(['type' => '3rd-place',  'event_id' => 4, 'team_id' => 10, 'slug' => '3rd-place-zimsko-2022']);
        Achievement::create(['type' => '4th-place',  'event_id' => 4, 'team_id' => 6,  'slug' => '4th-place-zimsko-2022']);
        Achievement::create(['type' => '5th-place',  'event_id' => 4, 'team_id' => 11, 'slug' => '5th-place-zimsko-2022']);
        Achievement::create(['type' => '6th-place',  'event_id' => 4, 'team_id' => 2,  'slug' => '6th-place-zimsko-2022']);
        Achievement::create(['type' => '7th-place',  'event_id' => 4, 'team_id' => 4,  'slug' => '7th-place-zimsko-2022']);
        Achievement::create(['type' => '8th-place',  'event_id' => 4, 'team_id' => 5,  'slug' => '8th-place-zimsko-2022']);

        // 2022 - Players
        Achievement::create(['type' => 'mvp',           'event_id' => 4, 'player_id' => 5,   'team_id' => 1,  'slug' => 'mvp-zimsko-2022']);
        Achievement::create(['type' => 'top-score',     'event_id' => 4, 'player_id' => 123, 'team_id' => 10, 'slug' => 'top-score-zimsko-2022']);
        Achievement::create(['type' => 'oldest-player', 'event_id' => 4, 'player_id' => 66,  'team_id' => 5,  'slug' => 'oldest-player-zimsko-2022']);
        Achievement::create(['type' => 'fan-favorites', 'event_id' => 4, 'team_id' => 5,     'slug' => 'fan-favorites-zimsko-2022']);

        // =============================

        // 2020 - Teams
        Achievement::create(['type' => 'champion',   'event_id' => 5, 'team_id' => 10, 'slug' => 'champion-zimsko-2020']);
        Achievement::create(['type' => '2nd-place',  'event_id' => 5, 'team_id' => 6,  'slug' => '2nd-place-zimsko-2020']);
        Achievement::create(['type' => '3rd-place',  'event_id' => 5, 'team_id' => 2,  'slug' => '3rd-place-zimsko-2020']);
        Achievement::create(['type' => '4th-place',  'event_id' => 5, 'team_id' => 8,  'slug' => '4th-place-zimsko-2020']);
        Achievement::create(['type' => '5th-place',  'event_id' => 5, 'team_id' => 4,  'slug' => '5th-place-zimsko-2020']);
        Achievement::create(['type' => '6th-place',  'event_id' => 5, 'team_id' => 5,  'slug' => '6th-place-zimsko-2020']);

        // 2020 - Players
        Achievement::create(['type' => 'top-score', 'event_id' => 5, 'player_id' => 126,  'team_id' => 10,   'slug' => 'top-score-zimsko-2020']);

        // =============================

        // 2019 - Teams
        Achievement::create(['type' => 'champion',   'event_id' => 6, 'team_id' => 10, 'slug' => 'champion-zimsko-2019']);
        Achievement::create(['type' => '2nd-place',  'event_id' => 6, 'team_id' => 6,  'slug' => '2nd-place-zimsko-2019']);
        Achievement::create(['type' => '3rd-place',  'event_id' => 6, 'team_id' => 5,  'slug' => '3rd-place-zimsko-2019']);
        Achievement::create(['type' => '4th-place',  'event_id' => 6, 'team_id' => 13, 'slug' => '4th-place-zimsko-2019']);
        Achievement::create(['type' => '5th-place',  'event_id' => 6, 'team_id' => 8,  'slug' => '5th-place-zimsko-2019']);

        // 2019 - Players
        Achievement::create(['type' => 'top-score', 'event_id' => 6, 'player_id' => 126,  'team_id' => 10,   'slug' => 'top-score-zimsko-2019']);

    }
}
