<x-ui.card class="mb-8" :title="$team->title" subtitle="Zadnje utakmice">
    @php

    @endphp

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b">
                <th class="pb-2 font-medium text-left text-gray-500">Protivnik</th>
                <th class="pb-2 font-medium text-right text-gray-500">Rezultat</th>
                <th class="pb-2 font-medium text-right text-gray-500">W/L</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
                @php
                    $opponent = $game->homeTeam->is($team) ? $game->awayTeam : $game->homeTeam;
                    $isWin = $team->id === $game->home_team_id ? $game->home_score > $game->away_score : $game->away_score > $game->home_score;
                @endphp

                <tr class="border-b last:border-b-0">
                    <td class="py-3">
                        <div class="flex items-center">
                            <img src="{{ $opponent->logo() }}" class="mr-2 w-6 h-6 rounded-full">
                            {{ $opponent->title }}
                        </div>
                    </td>
                    <td class="py-3 text-right">
                        @if ($team->id === $game->home_team_id)
                            <span class="{{ $game->home_score > $game->away_score ? 'text-green-500 font-semibold' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                            -
                            <span class="{{ $game->away_score > $game->home_score ? 'text-red-500 font-semibold' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                        @else
                            <span class="{{ $game->away_score > $game->home_score ? 'text-green-500 font-semibold' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                            -
                            <span class="{{ $game->home_score > $game->away_score ? 'text-red-500 font-semibold' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                        @endif
                    </td>
                    <td class="py-3 text-right">
                        @if ($isWin)
                            <svg class="inline-block w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="inline-block w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-ui.card>
