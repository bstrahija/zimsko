<?php

namespace App\Console\Commands;

use App\Legacy\Sync;
use App\Legacy\Sync3pts;
use App\Legacy\SyncStats as SyncStatsLegacy;
use App\Models\Event;
use App\Services\Stats;
use Illuminate\Console\Command;

class SyncPlayerStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-player-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync stats for players.';

    /**
     * Execute the console command.
     */
    public function handle(Sync $sync)
    {
        $this->info("Syncing stats.");
        $this->info("===============================================");

        $this->info("Syncing 3pts...");
        Sync3pts::run();

        $this->info("Syncing player stats (queued)...");
        $events = Event::with(['games'])->get();
        foreach ($events as $event) {
            $this->info("==> For event: " . $event->title);
            Stats::generateFromEventForPlayers(event: $event, generateForGames: true);
        }
        // Stats::generateTotalForPlayers();

        $this->info("===============================================");
        $this->info("Done.");
    }
}
