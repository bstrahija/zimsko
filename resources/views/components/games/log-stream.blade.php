@if ($live && $live['log'] && count($live['log']) > 1)
    <x-ui.card class="mb-8 col max-h-[80vh] overflow-y-auto" title="Tijek utakmice" subtitle="Uživo">
        @php
            $timeStart = microtime(true);
        @endphp

        @foreach ($live['log'] as $item)
            @php
                $item['submsg'] = '';
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
                    if ($item['subtype'] === 'tf' || $item['subtype'] === 'ff') {
                        $itemBgColor = 'bg-red-400/50';
                    }
                } elseif ($item['type'] === 'substitution') {
                    $icon = 'o-arrow-path-rounded-square';
                    $itemBgColor = 'bg-sky-200/80';
                    $itemColor = 'text-sky-600/80';
                } elseif ($item['type'] === 'timeout') {
                    $icon = 'o-clock';
                    $itemBgColor = 'bg-sky-200/60';
                    $itemColor = 'text-sky-600/80';
                } elseif ($item['type'] === 'game_ended') {
                    $icon = 'o-hand-raised';
                    $itemBgColor = 'bg-purple-200/60';
                    $itemColor = 'text-purple-600/80';
                } elseif ($item['type'] === 'game_started' || $item['type'] === 'game_starting_players' || $item['type'] === 'game_initialized') {
                    $icon = 'o-hand-raised';
                    $itemBgColor = 'bg-sky-200/60';
                    $itemColor = 'text-sky-600/80';
                }
                // dump($item);

                if (($item['type'] === 'player_score' || $item['type'] === 'player_miss') && $item['subtype'] === '3pt') {
                    $misses = collect($live['log'])
                        ->where('type', 'player_miss')
                        ->where('subtype', '3pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $made = collect($live['log'])
                        ->where('type', 'player_score')
                        ->where('subtype', '3pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $item['submsg'] = ' (' . $made . '/' . ($misses + $made) . ')';
                } elseif (($item['type'] === 'player_score' || $item['type'] === 'player_miss') && $item['subtype'] === '2pt') {
                    $misses = collect($live['log'])
                        ->where('type', 'player_miss')
                        ->where('subtype', '2pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $made = collect($live['log'])
                        ->where('type', 'player_score')
                        ->where('subtype', '2pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $item['submsg'] = ' (' . $made . '/' . ($misses + $made) . ')';
                } elseif (($item['type'] === 'player_score' || $item['type'] === 'player_miss') && $item['subtype'] === '1pt') {
                    $misses = collect($live['log'])
                        ->where('type', 'player_miss')
                        ->where('subtype', '1pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $made = collect($live['log'])
                        ->where('type', 'player_score')
                        ->where('subtype', '1pt')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $item['submsg'] = ' (' . $made . '/' . ($misses + $made) . ')';
                } elseif ($item['type'] === 'player_rebound') {
                    $count = collect($live['log'])
                        ->where('type', 'player_rebound')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $item['submsg'] = ' (' . $count . ')';
                } elseif ($item['type'] === 'player_assist') {
                    $count = collect($live['log'])->where('type', 'player_assist')->where('player_id', $item['player_id'])->where('created_at', '<=', $item['created_at'])->count();
                    $item['submsg'] = ' (' . $count . ')';
                } elseif ($item['type'] === 'player_steal') {
                    $count = collect($live['log'])->where('type', 'player_steal')->where('player_id', $item['player_id'])->where('created_at', '<=', $item['created_at'])->count();
                    $item['submsg'] = ' (' . $count . ')';
                } elseif ($item['type'] === 'player_turnover') {
                    $count = collect($live['log'])
                        ->where('type', 'player_turnover')
                        ->where('player_id', $item['player_id'])
                        ->where('created_at', '<=', $item['created_at'])
                        ->count();
                    $item['submsg'] = ' (' . $count . ')';
                } elseif ($item['type'] === 'player_steal') {
                    $count = collect($live['log'])->where('type', 'player_steal')->where('player_id', $item['player_id'])->where('created_at', '<=', $item['created_at'])->count();
                    $item['submsg'] = ' (' . $count . ')';
                } elseif ($item['type'] === 'player_foul') {
                    $count = collect($live['log'])->where('type', 'player_foul')->where('player_id', $item['player_id'])->where('created_at', '<=', $item['created_at'])->count();
                    $item['submsg'] = ' (' . $count . ')';
                }
            @endphp

            <div class="p-3 mb-4 {{ $itemBgColor }} rounded-lg shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="flex justify-between text-xs font-medium text-gray-700">
                    <div class="flex justify-start items-top">
                        <strong class="mr-2">
                            <span class="{{ $item['home_score'] > $item['away_score'] ? 'text-green-600' : 'font-normal' }}">{{ $item['home_score'] }}</span>
                            :
                            <span class="{{ $item['away_score'] > $item['home_score'] ? 'text-green-600' : 'font-normal' }}">{{ $item['away_score'] }}</span>
                        </strong>

                        @if ($icon)
                            <x-ui.icon icon="{{ $icon }}" class="size-4 mr-1 {{ $itemColor }}" />
                        @endif

                        <div>
                            <span>
                                {{ $item['message'] }}
                                <small>{{ $item['submsg'] }}</small>
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

        @php
            $timeEnd = microtime(true);

            // dividing with 60 will give the execution time in minutes otherwise seconds
            $executionTime = $timeEnd - $timeStart;

            // execution time of the script
            // echo '<b>Total Execution Time:</b> ' . $executionTime . ' Secs';

        @endphp
    </x-ui.card>
@endif
