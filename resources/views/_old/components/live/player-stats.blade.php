@php
    $playerStats = $this->getSortedPlayerStats($type);
@endphp

<div>
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-1 font-medium text-gray-500">#</th>
                    <th class="px-4 py-3 font-medium text-gray-500">Igrač</th>

                    @if ($type === 'score')
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Q1</th>
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Q2</th>
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Q3</th>
                        <th class="px-4 py-3 font-medium text-right text-gray-500">Q4</th>
                    @endif

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
                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold text-gray-600">{{ $player['number'] }}</td>
                        <td class="px-4 py-3 text-sm">{{ $player['name'] }}</td>

                        @if ($type === 'score')
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['score_p1'] }}</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['score_p2'] }}</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['score_p3'] }}</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['score_p4'] }}</td>
                        @endif

                        <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                            {{ $player['stats'][$type] }}
                        </td>

                        @if ($type === 'rebounds')
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['offensive_rebounds'] }}</td>
                            <td class="px-4 py-3 text-sm text-right">{{ $player['stats']['defensive_rebounds'] }}</td>
                        @endif

                        @if (isset($player['stats'][$type . '_percent']) || $type === 'score')
                            <td class="px-4 py-3 text-sm text-right">{{ $type === 'score' ? $player['stats']['field_goals_percent'] : $player['stats'][$type . '_percent'] }}%</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
