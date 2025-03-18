@php
    if ($type === 'score') {
        $stats = collect($stats)->sortByDesc($type)->values();
    } elseif ($type === 'three_points') {
        $stats = collect($stats)->sortByDesc('three_points_made')->values();
    } elseif ($type === 'field_goals') {
        $stats = collect($stats)->sortByDesc('field_goals_made')->values();
    } elseif ($type === 'free_throws') {
        $stats = collect($stats)->sortByDesc('free_throws_percent')->values();
    } else {
        $stats = collect($stats)->sortByDesc($type)->values();
    }
@endphp

<div>
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-1 font-medium text-gray-500">#</th>
                    <th class="px-4 py-3 font-medium text-gray-500 w-[60%]">Igrač</th>

                    <th class="px-4 py-3 font-medium text-right text-gray-500">Ukupno</th>

                    @if ($type === 'score')
                        <th class="px-4 py-3 font-medium text-right text-gray-500">U</th>
                    @endif

                    @if ($type === 'rebounds')
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Obrana</th>
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Napad</th>
                    @endif

                    @if (in_array($type, ['score', 'three_points', 'free_throws', 'assists', 'steals', 'blocks', 'fouls', 'turnovers', 'rebounds']))
                        <th class="px-4 py-3 font-medium text-right text-gray-500">AVG</th>
                    @endif

                    @if (in_array($type, ['score', 'three_points', 'field_goals', 'free_throws']))
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Postotak</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($stats as $index => $stat)
                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-semibold text-gray-600">{{ $stat['player_number'] }}</td>
                        <td class="px-4 py-3 text-xs">
                            <a href="{{ route('players.show', $stat['player_slug']) }}" class="flex items-center">
                                <img src="{{ $stat['player_photo'] ?: $team->logo() }}" alt="" class="mr-3 w-8 h-8 rounded-full">
                                <span class="font-medium text-gray-900">{{ $stat['player_name'] }}</span>
                            </a>
                        </td>

                        <td class="px-4 py-3 text-xs font-semibold text-right text-gray-800">
                            @if (isset($stat[$type . '_made']))
                                {{ $stat[$type . '_made'] }}/{{ $stat[$type] }}
                            @else
                                {{ $stat[$type] }}
                            @endif
                        </td>

                        @if ($type === 'score')
                            <td class="px-4 py-3 text-xs text-right max-w-1" title="Odigrano utakmica">
                                {{ $stat['games'] }}
                            </td>
                        @endif

                        @if ($type === 'rebounds')
                            <td class="px-4 py-3 text-xs text-right max-w-1">{{ $stat['offensive_rebounds'] }}</td>
                            <td class="px-4 py-3 text-xs text-right max-w-1">{{ $stat['defensive_rebounds'] }}</td>
                        @endif

                        @if (in_array($type, ['score', 'three_points', 'free_throws', 'assists', 'steals', 'blocks', 'fouls', 'turnovers', 'rebounds']))
                            <td class="px-4 py-3 text-xs text-right max-w-1 text-nowrap">
                                @if (isset($stat[$type . '_made']))
                                    {{ $stat['games'] ? round($stat[$type . '_made'] / $stat['games'], 1) : 0 }}
                                @else
                                    {{ $stat['games'] ? round($stat[$type] / $stat['games'], 1) : 0 }}
                                @endif
                            </td>
                        @endif

                        @if (isset($stat[$type . '_percent']) || $type === 'score')
                            <td class="px-4 py-3 text-xs text-right max-w-1 text-nowrap">
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
    </div>
</div>
