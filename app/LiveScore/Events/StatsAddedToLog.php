<?php

namespace App\LiveScore\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * This event triggers actions in the LiveScoreProvider
 *
 * @package App\LiveScore\Events
 */
class StatsAddedToLog implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameId = null;

    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct(int $gameId = null, array $data = null)
    {
        $this->gameId = $gameId;
        $this->data   = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [];
    }
}
