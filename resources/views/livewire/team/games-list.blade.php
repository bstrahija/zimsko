<?php

use App\Models\Team;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component
{
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
            ->with(['homeTeam', 'awayTeam', 'homeTeam.media', 'awayTeam.media'])
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);
    }
}; ?>

<div>
    <x-ui.card class="mb-8" :title="$team->title" subtitle="Sve utakmice">
        @if ($this->games && $this->games->count())
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="pb-2 text-left font-medium text-gray-500">Protivnik</th>
                        <th class="pb-2 text-right font-medium text-gray-500">Rezultat</th>
                        <th class="pb-2 text-right font-medium text-gray-500">W/L</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->games as $game)
                        @php
                            $opponent = $game->homeTeam->is($team) ? $game->awayTeam : $game->homeTeam;
                            $isWin =
                                $team->id === $game->home_team_id
                                    ? $game->home_score > $game->away_score
                                    : $game->away_score > $game->home_score;
                        @endphp

                        <tr class="border-b last:border-b-0">
                            <td class="py-3">
                                <a href="{{ route('games.show', $game->slug) }}" class="flex items-center">
                                    <img src="{{ $opponent->logo() }}" class="mr-2 h-6 w-6 rounded-full">
                                    {{ $opponent->title }}
                                </a>
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('games.show', $game->slug) }}">
                                    @if ($team->id === $game->home_team_id)
                                        <span
                                            class="{{ $game->home_score > $game->away_score ? 'font-semibold text-green-500' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                        -
                                        <span
                                            class="{{ $game->away_score > $game->home_score ? 'font-semibold text-red-500' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                    @else
                                        <span
                                            class="{{ $game->away_score > $game->home_score ? 'font-semibold text-green-500' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                        -
                                        <span
                                            class="{{ $game->home_score > $game->away_score ? 'font-semibold text-red-500' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    @endif
                                </a>
                            </td>
                            <td class="py-3 text-right">
                                @if ($isWin)
                                    <svg class="inline-block h-5 w-5 text-green-500" fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="inline-block h-5 w-5 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $this->games->links(data: ['scrollTo' => false]) }}
            </div>
        @else
            <p class="py-4 text-center text-sm text-gray-500">Nema dostupnih utakmica.</p>
        @endif
    </x-ui.card>
</div>
