<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Game;
use App\Services\LiveScore;
use Livewire\Component;

class LiveGame extends Component
{
    public $game;

    public $log;

    public $live;

    public $slug;

    // Special Syntax: ['echo:{channel},{event}' => '{method}']
    protected $listeners = ['echo:live-score,LiveScoreUpdated' => 'updateLiveScore'];

    public function mount()
    {
        $this->slug = request()->route()->parameter('slug');
        $this->loadGame();
    }

    public function loadGame()
    {
        $this->game = Game::where('slug', $this->slug)->first();
        $live       = new LiveScore($this->game);
        $this->live = $live->toData()['game'];
        $this->log  = $live->logStream();
    }

    public function updateLiveScore()
    {
        $this->loadGame();
    }

    public function getSortedPlayerStats(string $type)
    {
        $players = array_merge($this->live['home_players'], $this->live['away_players']);

        $sorted = collect($players)
            ->sortByDesc(function ($player) use ($type) {
                return $player['stats'][$type] ?? 0;
            })
            ->take(15)
            ->values()
            ->all();

        return $sorted;
    }

    public function render()
    {
        return view('livewire.live-game');
    }
}
