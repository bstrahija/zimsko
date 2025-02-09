@php
    // Here we need to sort the stats by the provided type
    if ($type === 'score') {
        $stats = collect($stats)->sortByDesc($type)->values();
    } elseif ($type === 'three_points') {
        $stats = collect($stats)->sortByDesc('three_points_made')->values();
    } elseif ($type === 'field_goals') {
        $stats = collect($stats)->sortByDesc('field_goals_made')->values();
    } elseif ($type === 'rebounds') {
        $stats = collect($stats)->sortByDesc('rebounds')->values();
    } elseif ($type === 'assists') {
        $stats = collect($stats)->sortByDesc('assists')->values();
    } elseif ($type === 'steals') {
        $stats = collect($stats)->sortByDesc('steals')->values();
    } elseif ($type === 'blocks') {
        $stats = collect($stats)->sortByDesc('blocks')->values();
    } elseif ($type === 'fouls') {
        $stats = collect($stats)->sortByDesc('fouls')->values();
    } elseif ($type === 'turnovers') {
        $stats = collect($stats)->sortByDesc('turnovers')->values();
    } elseif ($type === 'efficiency') {
        $stats = collect($stats)->sortByDesc('efficiency')->values();
    } else {
        $stats = collect($stats)->sortByDesc('field_goals_made')->values();
    }
@endphp

<div>
    <div class="overflow-x-auto w-full">
        <table class="w-full max-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-1 font-medium text-gray-500">#</th>
                    <th class="px-4 py-3 font-medium text-gray-500 w-[60%]">Ekipa</th>

                    <th class="px-4 py-3 font-medium text-right text-gray-500">Ukupno</th>

                    @if ($type === 'rebounds')
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Obrana</th>
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Napad</th>
                    @endif

                    @if (in_array($type, ['score', 'three_points', 'field_goals', 'free_throws']))
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Postotak</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($stats as $index => $stat)
                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold text-gray-600">{{ $index + 1 }}.</td>
                        <td class="px-4 py-3 text-sm">{{ $stat['team_title'] }}</td>

                        <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                            @if (isset($stat[$type . '_made']))
                                {{ $stat[$type . '_made'] }}/{{ $stat[$type] }}
                            @else
                                {{ $stat[$type] }}
                            @endif
                        </td>

                        @if ($type === 'rebounds')
                            <td class="px-4 py-3 text-sm text-right max-w-1">{{ $stat['offensive_rebounds'] }}</td>
                            <td class="px-4 py-3 text-sm text-right max-w-1">{{ $stat['defensive_rebounds'] }}</td>
                        @endif

                        @if (isset($stat[$type . '_percent']) || $type === 'score')
                            <td class="px-4 py-3 text-sm text-right max-w-1 text-nowrap">
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
