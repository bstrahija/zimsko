<?php

use App\Stats\Stats;
use App\Models\Event;
use App\Models\Player;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;

new class extends Component {
    public Player $player;

    public $selectedEventId = null;

    public function mount(Player $player): void
    {
        $this->player = $player;
        $this->selectedEventId = Event::current()->id;
    }

    #[Computed]
    public function events()
    {
        // Only newer events can be selected, since older ones don't have detailed stats
        return Event::where('scheduled_at', '>', '2025-01-01 00:00:00')->orderByDesc('scheduled_at')->get();
    }

    #[Computed]
    public function selectedEvent()
    {
        return $this->selectedEventId ? Event::find($this->selectedEventId) : null;
    }

    #[Computed]
    public function stats()
    {
        // If no event selected, show all-time stats
        if (!$this->selectedEventId || $this->selectedEventId === 'all') {
            return Stats::playerAllEventsStats($this->player->id);
        }

        $event = Event::find($this->selectedEventId);

        return Stats::playerEventStats($this->player->id, $event);
    }
}; ?>

<x-ui.card class="card mb-8" title="Statistika" subtitle="Statistika tokom turnira">
    <div class="relative mb-4 inline-block text-right">
        <select wire:model.live="selectedEventId"
            class="appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 pr-8 leading-tight text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="all">Svi događaji</option>
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

    @if ($this->stats)
        <table class="w-full text-left text-sm text-gray-700">
            <tbody class="divide-y divide-gray-100">
                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-200">
                    <th class="px-4 py-3 text-sm">UTAKMICA:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800" colspan="2">
                        {{ $this->stats['games'] }}
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">POENI:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['score'] }}
                    </td>
                    <td class="text-nowrap px-4 py-3 text-right text-sm">
                        {{ $this->stats['field_goals_percent'] }}%
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">PROSJEK:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['score_avg'] }}
                    </td>
                    <td class="text-nowrap px-4 py-3 text-right text-sm">
                        {{ $this->stats['field_goals_percent'] }}%
                    </td>
                </tr>
                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                    <th class="px-4 py-3 text-sm">3PT:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['three_points_made'] }} / {{ $this->stats['three_points'] }}
                    </td>
                    <td class="text-nowrap px-4 py-3 text-right text-sm">
                        {{ $this->stats['three_points_percent'] }}%
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">FG:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['field_goals_made'] }} / {{ $this->stats['field_goals'] }}
                    </td>
                    <td class="text-nowrap px-4 py-3 text-right text-sm">
                        {{ $this->stats['field_goals_percent'] }}%
                    </td>
                </tr>
                <tr class="hover:bg-gray-10 bg-gray-50 transition-colors duration-200">
                    <th class="px-4 py-3 text-sm">FT:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['free_throws_made'] }} / {{ $this->stats['free_throws'] }}
                    </td>
                    <td class="text-nowrap px-4 py-3 text-right text-sm">
                        {{ $this->stats['free_throws_percent'] }}%
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">AST:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['assists'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>AVG:</small> {{ $this->stats['assists_avg'] }}
                    </td>
                </tr>
                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                    <th class="px-4 py-3 text-sm">REB:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['rebounds'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>O:</small> {{ $this->stats['defensive_rebounds'] }} /
                        <small>D:</small> {{ $this->stats['offensive_rebounds'] }}
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">STL:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['steals'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>AVG:</small> {{ $this->stats['steals_avg'] }}
                    </td>
                </tr>
                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                    <th class="px-4 py-3 text-sm">BLK:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['blocks'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>AVG:</small> {{ $this->stats['blocks_avg'] }}
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">FOUL:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['fouls'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>AVG:</small> {{ $this->stats['fouls_avg'] }}
                    </td>
                </tr>
                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                    <th class="px-4 py-3 text-sm">TO:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800">
                        {{ $this->stats['turnovers'] }}
                    </td>
                    <td class="w-[20%] text-nowrap px-4 py-3 text-right text-sm">
                        <small>AVG:</small> {{ $this->stats['turnovers_avg'] }}
                    </td>
                </tr>
                <tr class="transition-colors duration-200 hover:bg-gray-50">
                    <th class="px-4 py-3 text-sm">EFF:</th>
                    <td class="px-4 py-3 text-right text-sm font-semibold text-gray-800" colspan="2">
                        {{ $this->stats['efficiency'] }}
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="border-l-4 border-yellow-500 bg-yellow-100 p-4 text-yellow-700">
            Nema podataka za odabrani događaj.
        </div>
    @endif
</x-ui.card>
