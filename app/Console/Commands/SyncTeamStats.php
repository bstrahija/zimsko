<?php

namespace App\Console\Commands;

use App\Legacy\Sync;
use App\Legacy\Sync3pts;
use App\Legacy\SyncRounds;
use App\Legacy\SyncStats as SyncStatsLegacy;
use Illuminate\Console\Command;

class SyncTeamStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-team-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync stats for teams.';

    /**
     * Execute the console command.
     */
    public function handle(Sync $sync)
    {
        $this->info("Syncing stats.");
        $this->info("===============================================");

        $this->info("Syncing rounds...");
        SyncRounds::run();
        $this->info("Syncing 3pts...");
        Sync3pts::run();
        $this->info("Syncing team stats...");
        SyncStatsLegacy::syncTeamStats();

        $this->info("===============================================");
        $this->info("Done.");
    }
}
