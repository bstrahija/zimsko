<?php

use App\Models\Event;
use App\Stats\Stats;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {
    #[Url(as: 'player_event')]
    public $selectedEventId = null;

    public $tabs = [
        'score' => 'Poeni',
        'three_points' => '3PT',
        'field_goals' => 'FG',
        'free_throws' => 'FT',
        'assists' => 'AST',
        'rebounds' => 'REB',
        'steals' => 'STL',
        'blocks' => 'BLK',
        'fouls' => 'FOULS',
        'turnovers' => 'TO',
        'efficiency' => 'EFF',
    ];

    public function mount()
    {
        // Set the initial selected event to the current event (only if not set from URL)
        if (is_null($this->selectedEventId)) {
            $this->selectedEventId = Event::current()->id;
        }
    }

    #[Computed]
    public function event()
    {
        return Event::find($this->selectedEventId);
    }

    #[Computed]
    public function events()
    {
        // Only newer events can be selected, since older ones don"t have detailed stats
        return Event::where('scheduled_at', '>', '2025-01-01 00:00:00')->orderByDesc('scheduled_at')->get();
    }

    #[Computed]
    public function teams()
    {
        return $this->event ? $this->event->teams : \App\Models\Team::all();
    }

    #[Computed]
    public function stats()
    {
        $selectedEventId = $this->selectedEventId ? (int) $this->selectedEventId : null;

        return Stats::playersEventStats(eventId: $selectedEventId);
    }
}; ?>

<x-ui.card class="col mb-8" title="Igrači" subtitle="Vodeći igrači tokom turnira">
    <div class="relative mb-3 inline-block text-right">
        <select wire:model.live="selectedEventId"
            class="appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 pr-8 leading-tight text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Svi događaji</option>
            @foreach ($this->events as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>

        <div class="pointer-events-none absolute right-0 top-3 flex items-center px-2">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>

    @if ($this->stats && count($this->stats))
        <div x-data="{ activeTab: 'score' }" class="mb-6">
            <div class="flex flex-wrap overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <button @click="activeTab = '{{ $key }}'"
                        :class="{ 'border-primary': activeTab === '{{ $key }}', 'border-transparent': activeTab !== '{{ $key }}' }"
                        class="whitespace-nowrap border-b-2 px-3 py-2 text-xs font-medium text-gray-600 hover:text-gray-800 sm:text-sm">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div x-show="activeTab === 'score'" class="mt-4">
                <x-stats.players-tab type="score" :stats="Arr::get($this->stats, 'score', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'three_points'" class="mt-4">
                <x-stats.players-tab type="three_points" :stats="Arr::get($this->stats, 'three_points', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'field_goals'" class="mt-4">
                <x-stats.players-tab type="field_goals" :stats="Arr::get($this->stats, 'field_goals', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'free_throws'" class="mt-4">
                <x-stats.players-tab type="free_throws" :stats="Arr::get($this->stats, 'free_throws', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'assists'" class="mt-4">
                <x-stats.players-tab type="assists" :stats="Arr::get($this->stats, 'assists', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'rebounds'" class="mt-4">
                <x-stats.players-tab type="rebounds" :stats="Arr::get($this->stats, 'rebounds', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'steals'" class="mt-4">
                <x-stats.players-tab type="steals" :stats="Arr::get($this->stats, 'steals', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'blocks'" class="mt-4">
                <x-stats.players-tab type="blocks" :stats="Arr::get($this->stats, 'blocks', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'fouls'" class="mt-4">
                <x-stats.players-tab type="fouls" :stats="Arr::get($this->stats, 'fouls', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'turnovers'" class="mt-4">
                <x-stats.players-tab type="turnovers" :stats="Arr::get($this->stats, 'turnovers', [])" :teams="$this->teams" />
            </div>

            <div x-show="activeTab === 'efficiency'" class="mt-4">
                <x-stats.players-tab type="efficiency" :stats="Arr::get($this->stats, 'efficiency', [])" :teams="$this->teams" />
            </div>
        </div>
    @else
        <p class="mt-4 text-center text-gray-500">Nema dostupnih podataka za odabrani događaj.</p>
    @endif
</x-ui.card>
