<?php

namespace App\Jobs;

use App\Legacy\SyncGames;
use App\Models\Event;
use App\Services\Cache;
use App\Stats\Stats;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateTotalStats implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?Event $event = null,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('Generating total stats (queued).');
        $start = microtime(true);

        // Pull data from game log and add to game_player
        Stats::addStatsFromLogToGameDataForEvent($this->event);

        // Gnerate actual data in the stats table
        Stats::generateTotalForTeams(generateForEvents: true, generateForGames: true, event: $this->event);
        Stats::generateTotalForPlayers(generateForEvents: true, generateForGames: true, event: $this->event);
        $time = microtime(true) - $start;
        Log::debug('Done generating total stats (queued). Elapsed: ' . $time . 's');
        Cache::clear();
        Log::debug('Cache cleared');
    }
}
