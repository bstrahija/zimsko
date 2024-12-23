<?php

namespace App\Console\Commands;

use App\Legacy\Sync;
use App\Legacy\Sync3pts;
use App\Legacy\SyncCategories;
use App\Legacy\SyncCoaches;
use App\Legacy\SyncEvents;
use App\Legacy\SyncGames;
use App\Legacy\SyncPages;
use App\Legacy\SyncPlayers;
use App\Legacy\SyncPosts;
use App\Legacy\SyncReferees;
use App\Legacy\SyncStats;
use App\Legacy\SyncTeams;
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
            SyncCategories::run($this->option('media'));
            $this->info("Syncing posts...");
            SyncPosts::run($this->option('media'));
            $this->info("Syncing pages...");
            SyncPages::run($this->option('media'));
            $this->info("Syncing events...");
            SyncEvents::run();
            $this->info("Syncing teams...");
            SyncTeams::run($this->option('media'));
            $this->info("Syncing players...");
            SyncPlayers::run($this->option('media'));
            $this->info("Syncing coaches...");
            SyncCoaches::run($this->option('media'));
            $this->info("Syncing referees...");
            SyncReferees::run($this->option('media'));
            $this->info("Syncing games...");
            SyncGames::run($this->option('media'));
            $this->info("Syncing 3pts...");
            Sync3pts::run();
            $this->info("Syncing team stats...");
            SyncStats::syncTeamStats();
            $this->info("Syncing player stats...");
            SyncStats::syncPlayerStats();
        } elseif ($this->option('content') === 'teams') {
            $this->info("Syncing teams...");
            SyncTeams::run($this->option('media'));
        }

        $this->info("===============================================");
        $this->info("Done.");
    }
}
