<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\LiveScore as LiveScoreService;
use Livewire\Component;

class LiveScore extends Component
{
    public $event;

    public $game;

    public $live;

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
            $this->game = $event->games()->where('status', 'in_progress')->orderBy('scheduled_at', 'desc')->first();

            if ($this->game) {
                $live = new LiveScoreService($this->game);
                $data = $live->toData();
                $this->live = $data['gameLive'];
            }
        }
    }

    public function updateLiveScore()
    {
        $this->loadGame();
    }

    public function render()
    {
        return view('livewire.live-score');
    }
}
