@if ($live && $live['log'] && count($live['log']) > 1)
    <x-ui.card class="mb-8 col max-h-[80vh] overflow-y-auto" title="Tijek utakmice" subtitle="Uživo">
        @foreach ($live['log'] as $item)
            @php
                $icon = null;
                $itemBgColor = 'bg-gray-50';
                $itemColor = 'text-gray-50';
                if ($item['type'] === 'player_score') {
                    $icon = 'o-check-circle';
                    $itemBgColor = 'bg-green-100/80';
                    $itemColor = 'text-green-600';
                } elseif ($item['type'] === 'player_miss') {
                    $icon = 'o-x-circle';
                    $itemBgColor = 'bg-rose-100/80';
                    $itemColor = 'text-red-500/80';
                } elseif ($item['type'] === 'player_rebound') {
                    $icon = 'o-arrow-top-right-on-square';
                    $itemColor = 'text-amber-600/80';
                } elseif ($item['type'] === 'player_turnover') {
                    $icon = 'o-minus-circle';
                    $itemColor = 'text-rose-600/80';
                } elseif ($item['type'] === 'player_steal') {
                    $icon = 'o-minus-circle';
                    $itemColor = 'text-rose-600/80';
                } elseif ($item['type'] === 'player_block') {
                    $icon = 'o-hand-raised';
                    $itemColor = 'text-amber-600/80';
                } elseif ($item['type'] === 'player_foul') {
                    $icon = 'o-exclamation-triangle';
                    $itemColor = 'text-red-600/80';
                } elseif ($item['type'] === 'substitution') {
                    $icon = 'o-arrow-path-rounded-square';
                    $itemBgColor = 'bg-sky-200/80';
                    $itemColor = 'text-sky-600/80';
                } elseif ($item['type'] === 'game_ended') {
                    $icon = 'o-hand-raised';
                    $itemBgColor = 'bg-purple-200/80';
                    $itemColor = 'text-purple-600/80';
                } elseif ($item['type'] === 'game_started' || $item['type'] === 'game_starting_players' || $item['type'] === 'game_initialized') {
                    $icon = 'o-hand-raised';
                    $itemBgColor = 'bg-sky-200/60';
                    $itemColor = 'text-sky-600/80';
                }
            @endphp

            <div class="p-3 mb-4 {{ $itemBgColor }} rounded-lg shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="flex justify-between text-sm text-gray-700">
                    <div class="flex justify-start items-center">
                        <strong class="mr-2">
                            {{ $item['home_score'] }}
                            :
                            {{ $item['away_score'] }}
                        </strong>

                        @if ($icon)
                            <x-ui.icon icon="{{ $icon }}" class="size-5 mr-1 {{ $itemColor }}" />
                        @endif

                        <span>
                            {{ $item['message'] }}
                        </span>

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
                            Q{{ $item['period'] }}
                        @else
                            OT{{ $item['period'] - 4 }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </x-ui.card>
@endif
