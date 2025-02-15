<x-ui.card class="mb-8" title="Međusobne utakmice" subtitle="Sve utakmice odabranih ekipa">
    <table class="w-full text-sm">

        <tbody class="divide-y divide-gray-200">
            @foreach ($games as $game)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 {{ $game->home_score > $game->away_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                        <div class="flex items-center">
                            <img src="{{ $game->homeTeam->logo() }}" class="mr-2 w-6 h-6 rounded-full">
                            <span class="hidden sm:inline">{{ $game->homeTeam->title }}</span>
                        </div>
                    </td>
                    <td class="py-3 font-medium text-center text-gray-800">
                        <span class="{{ $game->home_score > $game->away_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $game->home_score }} </span>
                        -
                        <span class="{{ $game->away_score > $game->home_score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                    </td>
                    <td class="py-3 text-right {{ $game->away_score > $game->home_score ? 'text-green-600 font-semibold' : 'text-gray-700' }}">
                        <div class="flex justify-end items-center">
                            <span class="hidden sm:inline">{{ $game->awayTeam->title }}</span>
                            <img src="{{ $game->awayTeam->logo() }}" class="ml-2 w-6 h-6 rounded-full">
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</x-ui.card>
