<?php

namespace App\Console\Commands;

use App\Legacy\Sync;
use Illuminate\Console\Command;

class SyncLegacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-legacy {--content=all} {--media=true} {--clear} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data from legacy WordPress database to new database.';

    /**
     * Execute the console command.
     */
    public function handle(Sync $sync)
    {
        if ($this->option('clear')) {
            $this->info("Clearing data from new database.");
            $sync->clear();
        }

        $this->info("Syncing data from legacy WordPress database to new database.");
        $this->info("===============================================");

        if ($this->option('content') === 'all') {
            $this->info("Syncing categories...");
            $sync->syncCategories($this->option('media'));
            $this->info("Syncing posts...");
            $sync->syncPosts($this->option('media'));
            $this->info("Syncing pages...");
            $sync->syncPages($this->option('media'));
            $this->info("Syncing events...");
            $sync->syncEvents();
            $this->info("Syncing teams...");
            $sync->syncTeams($this->option('media'));
            $this->info("Syncing players...");
            $sync->syncPlayers($this->option('media'));
            $this->info("Syncing coaches...");
            $sync->syncCoaches($this->option('media'));
            $this->info("Syncing referees...");
            $sync->syncReferees($this->option('media'));
            $this->info("Syncing games...");
            $sync->syncGames($this->option('media'));
            $this->info("Syncing player stats...");
            $sync->syncPlayerStats();
            $this->info("Syncing team stats...");
            $sync->syncTeamStats();
        } elseif ($this->option('content') === 'teams') {
            $this->info("Syncing teams...");
            $sync->syncTeams();
        }

        $this->info("===============================================");
        $this->info("Done.");
    }
}
