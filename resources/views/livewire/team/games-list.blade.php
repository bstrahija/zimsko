<?php

use App\Models\Team;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public Team $team;

    public function paginationView()
    {
        return 'livewire::tailwind';
    }

    #[Computed]
    public function games()
    {
        return $this->team
            ->games()
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media', 'event'])
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);
    }
}; ?>

<div>
    <x-ui.card class="mb-8" :title="$team->title" subtitle="Sve utakmice">
        @if ($this->games && $this->games->count())
            <div class="divide-y divide-gray-200">
                @foreach ($this->games as $game)
                    @php
                        $opponent = $game->homeTeam->is($team) ? $game->awayTeam : $game->homeTeam;
                        $isWin =
                            $team->id === $game->home_team_id
                                ? $game->home_score > $game->away_score
                                : $game->away_score > $game->home_score;
                    @endphp

                    <div x-data="{ open: false }" class="py-3">
                        {{-- Main row - clickable --}}
                        <button @click="open = !open" type="button"
                            class="flex w-full items-center justify-between text-left">
                            <div class="flex min-w-0 flex-1 items-center gap-3">
                                <img src="{{ $opponent->logo() }}" class="h-8 w-8 flex-shrink-0 rounded-full"
                                    alt="{{ $opponent->title }}">
                                <span class="truncate text-sm font-medium text-gray-900">{{ $opponent->title }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                {{-- Score --}}
                                <span class="text-sm">
                                    @if ($team->id === $game->home_team_id)
                                        <span
                                            class="{{ $game->home_score > $game->away_score ? 'font-semibold text-green-500' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                        <span class="text-gray-400">-</span>
                                        <span
                                            class="{{ $game->away_score > $game->home_score ? 'font-semibold text-red-500' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                    @else
                                        <span
                                            class="{{ $game->away_score > $game->home_score ? 'font-semibold text-green-500' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                        <span class="text-gray-400">-</span>
                                        <span
                                            class="{{ $game->home_score > $game->away_score ? 'font-semibold text-red-500' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    @endif
                                </span>

                                {{-- Win/Loss indicator --}}
                                @if ($isWin)
                                    <svg class="h-5 w-5 flex-shrink-0 text-green-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif

                                {{-- Chevron --}}
                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        {{-- Expanded content --}}
                        <div x-show="open" x-collapse x-cloak class="mt-3 rounded-lg bg-gray-50 p-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {{-- Left column - Game details --}}
                                <div class="space-y-2 text-sm">
                                    @if ($game->event)
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            <span class="text-gray-600">{{ $game->event->title }}</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-600">{{ $game->scheduled_at->format('d.m.Y') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-gray-600">{{ $game->scheduled_at->format('H:i') }}</span>
                                    </div>
                                </div>

                                {{-- Right column - Score by periods --}}
                                <div class="text-sm">
                                    <div class="mb-2 text-xs font-medium uppercase text-gray-500">Rezultat po
                                        četvrtinama</div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-center">
                                            <thead>
                                                <tr class="border-b text-xs text-gray-500">
                                                    <th class="pb-1 text-left font-medium">Ekipa</th>
                                                    <th class="pb-1 font-medium">Q1</th>
                                                    <th class="pb-1 font-medium">Q2</th>
                                                    <th class="pb-1 font-medium">Q3</th>
                                                    <th class="pb-1 font-medium">Q4</th>
                                                    @if ($game->home_score_p5 || $game->away_score_p5)
                                                        <th class="pb-1 font-medium">OT</th>
                                                    @endif
                                                    <th class="pb-1 font-medium">Ukupno</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Home team row --}}
                                                <tr class="border-b text-xs">
                                                    <td class="py-1.5 text-left">
                                                        <div class="flex items-center gap-1">
                                                            <img src="{{ $game->homeTeam->logo() }}"
                                                                class="h-4 w-4 rounded-full" alt="">
                                                            <span
                                                                class="{{ $game->homeTeam->is($team) ? 'font-semibold' : '' }} truncate">{{ Str::limit($game->homeTeam->title, 10) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-1.5">{{ $game->home_score_p1 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->home_score_p2 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->home_score_p3 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->home_score_p4 ?? '-' }}</td>
                                                    @if ($game->home_score_p5 || $game->away_score_p5)
                                                        <td class="py-1.5">{{ $game->home_score_p5 ?? '-' }}</td>
                                                    @endif
                                                    <td
                                                        class="{{ $game->home_score > $game->away_score ? 'text-green-600' : '' }} py-1.5 font-semibold">
                                                        {{ $game->home_score }}</td>
                                                </tr>
                                                {{-- Away team row --}}
                                                <tr class="text-xs">
                                                    <td class="py-1.5 text-left">
                                                        <div class="flex items-center gap-1">
                                                            <img src="{{ $game->awayTeam->logo() }}"
                                                                class="h-4 w-4 rounded-full" alt="">
                                                            <span
                                                                class="{{ $game->awayTeam->is($team) ? 'font-semibold' : '' }} truncate">{{ Str::limit($game->awayTeam->title, 10) }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-1.5">{{ $game->away_score_p1 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->away_score_p2 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->away_score_p3 ?? '-' }}</td>
                                                    <td class="py-1.5">{{ $game->away_score_p4 ?? '-' }}</td>
                                                    @if ($game->home_score_p5 || $game->away_score_p5)
                                                        <td class="py-1.5">{{ $game->away_score_p5 ?? '-' }}</td>
                                                    @endif
                                                    <td
                                                        class="{{ $game->away_score > $game->home_score ? 'text-green-600' : '' }} py-1.5 font-semibold">
                                                        {{ $game->away_score }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Link at the bottom --}}
                            <div class="mt-4 border-t border-gray-200 pt-3">
                                <a href="{{ route('games.show', $game->slug) }}"
                                    class="inline-flex items-center gap-2 text-primary hover:underline">
                                    <span>Detalji utakmice</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $this->games->links(data: ['scrollTo' => false]) }}
            </div>
        @else
            <p class="py-4 text-center text-sm text-gray-500">Nema dostupnih utakmica.</p>
        @endif
    </x-ui.card>
</div>
