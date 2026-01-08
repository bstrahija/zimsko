<?php

use App\Stats\Stats;
use App\Models\Event;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;

new class extends Component {
    public $team;

    public $selectedEventId = null;

    public function mount()
    {
        // Set the initial selected event to the current event
        $this->selectedEventId = Event::current()->id;
    }

    #[Computed]
    public function events()
    {
        // Only newer events can be selected, since older ones don"t have detailed stats
        return Event::where('scheduled_at', '>', '2025-01-01 00:00:00')->orderByDesc('scheduled_at')->get();
    }

    #[Computed]
    public function stats()
    {
        $selectedEventId = $this->selectedEventId ?: null;

        return collect(Stats::teamPlayerEventStats($this->team->id, $selectedEventId))
            ->sortByDesc('score')
            ->values()
            ->all();
    }
}; ?>

<x-ui.card class="card mb-8" title="Igrači" subtitle="Svi igrači u ekipi">
    <div>
        <select wire:model.live="selectedEventId" class="mb-4 rounded border px-3 py-2">
            <option value="">Svi događaji</option>
            @foreach ($this->events as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>
    </div>

    <div x-data="{ activeTab: 'score' }" class="mb-6">
        <div class="flex flex-wrap overflow-x-auto">
            @php
                $tabs = [
                    'score' => 'Igrači',
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
            @endphp
            @foreach ($tabs as $key => $label)
                <button @click="activeTab = '{{ $key }}'"
                    :class="{ 'border-primary': activeTab === '{{ $key }}', 'border-transparent': activeTab !== '{{ $key }}' }"
                    class="whitespace-nowrap border-b-2 px-3 py-2 text-xs font-medium text-gray-600 hover:text-gray-800 sm:text-sm">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div x-show="activeTab === 'score'" class="mt-4">
            <x-teams.player-stats-tab type="score" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'three_points'" class="mt-4">
            <x-teams.player-stats-tab type="three_points" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'field_goals'" class="mt-4">
            <x-teams.player-stats-tab type="field_goals" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'free_throws'" class="mt-4">
            <x-teams.player-stats-tab type="free_throws" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'assists'" class="mt-4">
            <x-teams.player-stats-tab type="assists" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'rebounds'" class="mt-4">
            <x-teams.player-stats-tab type="rebounds" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'steals'" class="mt-4">
            <x-teams.player-stats-tab type="steals" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'blocks'" class="mt-4">
            <x-teams.player-stats-tab type="blocks" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'fouls'" class="mt-4">
            <x-teams.player-stats-tab type="fouls" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'turnovers'" class="mt-4">
            <x-teams.player-stats-tab type="turnovers" :stats="$this->stats" :team="$team" />
        </div>

        <div x-show="activeTab === 'efficiency'" class="mt-4">
            <x-teams.player-stats-tab type="efficiency" :stats="$this->stats" :team="$team" />
        </div>
    </div>
</x-ui.card>
