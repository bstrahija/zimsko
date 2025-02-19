@php
    $playerStats = \App\Services\Helpers::getSortedPlayerStats($game, $type); //$this->getSortedPlayerStats($type);
@endphp

<div>
    <div class="overflow-x-auto w-full">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700 whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 w-1 font-medium text-gray-500">#</th>
                        <th class="px-4 py-3 font-medium text-gray-500">Igrač</th>
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
                    @foreach ($playerStats as $player)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} transition-colors duration-200 hover:bg-gray-100">
                            <td class="px-3 py-2 text-xs font-semibold text-gray-600">{{ $player['number'] ?? ($player['pivot']['number'] ?? '-') }}</td>
                            <td class="px-3 py-2 text-xs font-semibold">{{ $player['name'] }}</td>
                            <td class="px-3 py-2 text-xs font-semibold text-right text-gray-800">
                                @if (isset($player['stats'][$type . '_made']))
                                    {{ $player['stats'][$type . '_made'] }}/{{ $player['stats'][$type] }}
                                @else
                                    {{ $player['stats'][$type] }}
                                @endif
                            </td>
                            @if ($type === 'rebounds')
                                <td class="px-3 py-2 text-xs text-right">{{ $player['stats']['offensive_rebounds'] }}</td>
                                <td class="px-3 py-2 text-xs text-right">{{ $player['stats']['defensive_rebounds'] }}</td>
                            @endif
                            @if (isset($player['stats'][$type . '_percent']) || $type === 'score')
                                <td class="px-3 py-2 text-xs text-right">
                                    @if (isset($player['stats'][$type . '_made']))
                                        {{ $player['stats'][$type . '_made'] }}/{{ $player['stats'][$type] }}
                                        <small>({{ $player['stats'][$type . '_percent'] ?: 0 }}%)</small>
                                    @else
                                        {{ $type === 'score' ? $player['stats']['field_goals_percent'] : $player['stats'][$type . '_percent'] }}%
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
