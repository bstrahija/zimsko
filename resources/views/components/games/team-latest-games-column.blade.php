<x-ui.card class="mb-8" :title="$team->title" subtitle="Zadnje utakmice">
    @php

    @endphp

    @if ($games && $games->count())
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="pb-2 text-left font-medium text-gray-500">Protivnik</th>
                    <th class="pb-2 text-right font-medium text-gray-500">Rezultat</th>
                    <th class="pb-2 text-right font-medium text-gray-500">W/L</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
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
                                        class="{{ $game->home_score > $game->away_score ? 'text-green-500 font-semibold' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    -
                                    <span
                                        class="{{ $game->away_score > $game->home_score ? 'text-red-500 font-semibold' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                @else
                                    <span
                                        class="{{ $game->away_score > $game->home_score ? 'text-green-500 font-semibold' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                    -
                                    <span
                                        class="{{ $game->home_score > $game->away_score ? 'text-red-500 font-semibold' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                @endif
                            </a>
                        </td>
                        <td class="py-3 text-right">
                            @if ($isWin)
                                <svg class="inline-block h-5 w-5 text-green-500" fill="none" stroke="currentColor"
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

        <div class="mt-4 text-center">
            <a href="{{ route('teams.games', $team->slug) }}"
                class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary/90">
                Sve Utakmice
                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    @else
        <p class="py-4 text-center text-sm text-gray-500">Nema dostupnih utakmica.</p>
    @endif
</x-ui.card>
