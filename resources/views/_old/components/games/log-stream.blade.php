<x-ui.card class="mb-8 col max-h-[80vh] overflow-y-auto" title="Tijek utakmice" subtitle="Uživo">
    @foreach ($log as $item)
        <div class="p-3 mb-4 bg-gray-50 rounded-lg shadow-sm transition-all duration-300 hover:shadow-md">
            <div class="flex justify-between text-sm text-gray-700">
                <div>
                    <strong class="mr-2">
                        {{ $item['home_score'] }}
                        :
                        {{ $item['away_score'] }}
                    </strong>
                    {{ $item['message'] }}

                    @if ($item['type'] === 'game_starting_players')
                        @php
                            $homeStarting = $game->homePlayers->whereIn('id', $game->home_starting_players)->values();
                            $awayStarting = $game->awayPlayers->whereIn('id', $game->away_starting_players)->values();
                        @endphp

                        @if ($homeStarting)
                            <h3 class="mt-2 font-semibold">{{ $game->homeTeam->title }}</h3>
                            <ul class="text-xs">
                                @foreach ($homeStarting as $player)
                                    <li>{{ $player->name }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($awayStarting)
                            <h3 class="mt-2 font-semibold">{{ $game->awayTeam->title }}</h3>
                            <ul class="text-xs">
                                @foreach ($awayStarting as $player)
                                    <li>{{ $player->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>

                <div>
                    @if ($item['period'] <= 4)
                        Četvrtina: {{ $item['period'] }}
                    @else
                        Produžetak: {{ $item['period'] - 4 }}
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</x-ui.card>
