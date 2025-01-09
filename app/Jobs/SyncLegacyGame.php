<?php

namespace App\Jobs;

use App\Legacy\SyncGames;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncLegacyGame implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $game
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('Syncing legacy game: ' . $this->game->title);
        SyncGames::syncGame($this->game);
    }
}
