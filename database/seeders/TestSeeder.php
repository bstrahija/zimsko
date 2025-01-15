<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\GameTeam;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::query()->create([
            'title' => 'Test event',
            'slug'  => 'test-event',
            'scheduled_at' => '2000-01-01 00:00:00',
        ]);
    }
}
