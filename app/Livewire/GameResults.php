<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class GameResults extends Component
{
    use WithPagination;

    public $selectedEventSlug = '';

    public $selectedEvent = null;

    public $events = [];

    // public $results = [];

    public function mount()
    {
        $this->events        = Event::orderByDesc('scheduled_at')->get();
        $this->selectedEventSlug = Event::current()->slug;
        $this->selectedEvent = $this->selectedEventSlug ? Event::where('slug', $this->selectedEventSlug)->first() : Event::current();

        // Reload the results
        $this->reloadResults();
    }

    public function reloadResults()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->selectedEvent = $this->selectedEventSlug ? Event::where('slug', $this->selectedEventSlug)->first() : Event::current();
        $results = $this->selectedEvent->games()->orderByDesc('scheduled_at')->with('homeTeam', 'awayTeam')->paginate(25);


        return view('livewire.game-results', [
            'results' => $results,
        ]);
    }
}
