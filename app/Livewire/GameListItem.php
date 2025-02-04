<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\GameLive;
use App\Services\LiveScore as LiveScoreService;
use Livewire\Component;

class GameListItem extends Component
{
    public $event;

    public $game;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = ['echo:live-score,LiveScoreUpdated' => 'updateLiveScore'];

    public function mount()
    {
        $this->loadGame();
    }

    public function loadGame()
    {
        // First we need an event
        $event = Event::current() ?: (Event::last() ?: null);

        if ($event) {
            $this->game = $event->games()
                ->with(['homeTeam', 'awayTeam', 'homeTeam.players', 'awayTeam.players', 'homeTeam.players.media', 'awayTeam.players.media'])
                ->where('status', 'in_progress')
                ->orderBy('scheduled_at', 'desc')
                ->first();
        }
    }

    public function updateLiveScore()
    {
        $this->loadGame();
    }

    public function render()
    {
        return view('livewire.game-list-item');
    }
}
