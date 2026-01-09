<div>
    <div class="w-full overflow-x-auto">
        @if ($stats && count($stats))
            <table class="w-full text-left text-sm text-gray-700">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="w-1 px-4 py-3 font-medium text-gray-500"></th>
                        <th class="w-[60%] py-3 pl-1 pr-4 font-medium text-gray-500">Igrač</th>

                        <th class="px-4 py-3 text-right font-medium text-gray-500">Ukupno</th>

                        @if ($type === 'rebounds')
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Obrana</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Napad</th>
                        @endif

                        @if (in_array($type, [
                                'score',
                                'three_points',
                                'free_throws',
                                'assists',
                                'steals',
                                'blocks',
                                'fouls',
                                'turnovers',
                                'rebounds',
                            ]))
                            <th class="px-4 py-3 text-right font-medium text-gray-500">AVG</th>
                        @endif

                        @if (in_array($type, ['score', 'three_points', 'field_goals', 'free_throws']))
                            <th class="px-4 py-3 text-right font-medium text-gray-500">Postotak</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($stats as $index => $stat)
                        @php
                            $team = isset($stat['team_id']) ? $teams->where('id', $stat['team_id'])->first() : null;
                        @endphp

                        <tr class="transition-colors duration-200 hover:bg-gray-50">
                            <td class="px-2 py-3 text-sm font-semibold text-gray-600">{{ $index + 1 }}.</td>
                            <td class="py-3 pl-0 pr-4 text-xs">
                                <a href="{{ route('players.show', $stat['player_slug']) }}" class="flex items-center">
                                    <x-global.player-photo-for-tables :playerPhoto="$stat['player_photo']" :teamLogo="$team->logo()"
                                        class="mr-3" />
                                    <span class="font-medium text-gray-900">{{ $stat['player_name'] }}</span>
                                </a>
                            </td>

                            <td class="px-4 py-3 text-right text-xs font-semibold text-gray-800">
                                @if (isset($stat[$type . '_made']))
                                    {{ $stat[$type . '_made'] }}/{{ $stat[$type] }}
                                @else
                                    {{ $stat[$type] }}
                                @endif
                            </td>

                            @if ($type === 'rebounds')
                                <td class="max-w-1 px-4 py-3 text-right text-xs">{{ $stat['offensive_rebounds'] }}</td>
                                <td class="max-w-1 px-4 py-3 text-right text-xs">{{ $stat['defensive_rebounds'] }}</td>
                            @endif

                            @if (in_array($type, [
                                    'score',
                                    'three_points',
                                    'free_throws',
                                    'assists',
                                    'steals',
                                    'blocks',
                                    'fouls',
                                    'turnovers',
                                    'rebounds',
                                ]))
                                <td class="max-w-1 text-nowrap px-4 py-3 text-right text-xs">
                                    @if (isset($stat[$type . '_made']))
                                        {{ $stat['games'] ? round($stat[$type . '_made'] / $stat['games'], 1) : 0 }}
                                    @else
                                        {{ $stat['games'] ? round($stat[$type] / $stat['games'], 1) : 0 }}
                                    @endif
                                </td>
                            @endif

                            @if (isset($stat[$type . '_percent']) || $type === 'score')
                                <td class="max-w-1 text-nowrap px-4 py-3 text-right text-xs">
                                    @if (isset($stat[$type . '_made']))
                                        {{ $stat[$type . '_made'] }}
                                        /
                                        {{ $stat[$type] }}
                                        <small>({{ $stat[$type . '_percent'] ?: 0 }}%)</small>
                                    @else
                                        {{ $type === 'score' ? $stat['field_goals_percent'] : $stat[$type . '_percent'] }}%
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="mt-4 text-center text-gray-500">Nema dostupnih podataka za odabrani događaj.</p>
        @endif
    </div>
</div>
