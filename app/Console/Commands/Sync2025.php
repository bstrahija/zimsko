<?php

namespace App\Console\Commands;

use App\Legacy\Sync;
use App\Legacy\SyncZimsko2025;
use Illuminate\Console\Command;

class Sync2025 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-2025';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync games for Zimsko 2025.';

    /**
     * Execute the console command.
     */
    public function handle(Sync $sync)
    {
        $this->info("Syncing games for 2025.");
        $this->info("===============================================");

        $this->info("Syncing games...");
        SyncZimsko2025::run();

        $this->info("===============================================");
        $this->info("Done.");
    }
}
