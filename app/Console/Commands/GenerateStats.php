<?php

namespace App\Console\Commands;

use App\Models\GameLog;
use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate stats for various pats of the league/tournament';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // $gameLogs = GameLog::all();
    }
}
