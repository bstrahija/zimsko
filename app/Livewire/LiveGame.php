<?php

namespace App\Livewire;

use App\Models\Game;
use App\LiveScore\LiveScore as LiveScoreService;
use Livewire\Component;

class LiveGame extends Component
{
    public $game;

    public $log;

    public $live;

    public $slug;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = ['echo:live-score,\App\LiveScore\Events\LiveScoreUpdated' => 'updateLiveScore'];

    public function mount()
    {
        $this->slug = request()->route()->parameter('slug');
        $this->loadGame();
    }

    public function loadGame()
    {
        $this->game = Game::where('slug', $this->slug)->first();
        $live       = LiveScoreService::build($this->game);
        $this->live = $live->toOptimizedData();
    }

    public function updateLiveScore()
    {
        $this->loadGame();
    }

    public function render()
    {
        return view('livewire.live-game');
    }
}
