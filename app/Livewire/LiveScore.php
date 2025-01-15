<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\GameLive;
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
            $this->game = $event->games()
                ->with(['homeTeam', 'awayTeam', 'homeTeam.players', 'awayTeam.players', 'homeTeam.players.media', 'awayTeam.players.media'])
                ->where('status', 'in_progress')
                ->orderBy('scheduled_at', 'desc')
                ->first();

            if ($this->game) {
                $this->live = GameLive::where('game_id', $this->game->id)->first();
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
