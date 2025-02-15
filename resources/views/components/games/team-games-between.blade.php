<x-ui.card class="mb-8" title="Međusobne utakmice" subtitle="Sve utakmice odabranih ekipa">
    <table class="w-full text-sm">

        <tbody class="divide-y divide-gray-200">
            @foreach ($games as $gameBetween)
                <tr class="hover:bg-gray-50">
                    @if ($gameBetween->homeTeam->id === $game->homeTeam->id)
                        <td class="py-3 {{ $gameBetween->home_score > $gameBetween->away_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                            <div class="flex items-center">
                                <img src="{{ $gameBetween->homeTeam->logo() }}" class="mr-2 w-6 h-6 rounded-full">
                                <span class="hidden sm:inline">{{ $gameBetween->homeTeam->title }}</span>
                            </div>
                        </td>
                    @else
                        <td class="py-3 {{ $gameBetween->away_score > $gameBetween->home_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                            <div class="flex items-center">
                                <img src="{{ $gameBetween->awayTeam->logo() }}" class="mr-2 w-6 h-6 rounded-full">
                                <span class="hidden sm:inline">{{ $gameBetween->awayTeam->title }}</span>
                            </div>
                        </td>
                    @endif

                    <td class="py-3 font-medium text-center text-gray-800">
                        @if ($gameBetween->homeTeam->id === $game->homeTeam->id)
                            <span
                                class="{{ $gameBetween->home_score > $gameBetween->away_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $gameBetween->home_score }}
                            @else
                                <span
                                    class="{{ $gameBetween->away_score > $gameBetween->home_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $gameBetween->away_score }}</span>
                        @endif
                        </span>
                        -
                        @if ($gameBetween->homeTeam->id === $game->homeTeam->id)
                            <span
                                class="{{ $gameBetween->away_score > $gameBetween->home_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $gameBetween->away_score }}</span>
                        @else
                            <span
                                class="{{ $gameBetween->home_score > $gameBetween->away_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $gameBetween->home_score }}</span>
                        @endif
                    </td>

                    @if ($gameBetween->awayTeam->id === $game->awayTeam->id)
                        <td class="py-3 text-right {{ $gameBetween->away_score > $gameBetween->home_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                            <div class="flex justify-end items-center">
                                <span class="hidden sm:inline">{{ $gameBetween->awayTeam->title }}</span>
                                <img src="{{ $gameBetween->awayTeam->logo() }}" class="ml-2 w-6 h-6 rounded-full">
                            </div>
                        </td>
                    @else
                        <td class="py-3 text-right {{ $gameBetween->home_score > $gameBetween->away_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                            <div class="flex justify-end items-center">
                                <span class="hidden sm:inline">{{ $gameBetween->homeTeam->title }}</span>
                                <img src="{{ $gameBetween->homeTeam->logo() }}" class="ml-2 w-6 h-6 rounded-full">
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>


</x-ui.card>
