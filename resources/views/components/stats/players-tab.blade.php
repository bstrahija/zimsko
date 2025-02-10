<div>
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 w-1 font-medium text-gray-500"></th>
                    <th class="pr-4 pl-1 py-3 font-medium text-gray-500 w-[60%]">Igrač</th>

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
                    @php
                        $team = isset($stat['team_id']) ? $teams->where('id', $stat['team_id'])->first() : null;
                    @endphp

                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-2 py-3 text-sm font-semibold text-gray-600">{{ $index + 1 }}.</td>
                        <td class="py-3 pr-4 pl-0 text-xs">
                            <a href="{{ route('players.show', $stat['player_slug']) }}" class="flex items-center">
                                <x-global.player-photo-for-tables :playerPhoto="$stat['player_photo']" :teamLogo="$team->logo()" class="mr-3" />
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

                        @if ($type === 'rebounds')
                            <td class="px-4 py-3 text-xs text-right max-w-1">{{ $stat['offensive_rebounds'] }}</td>
                            <td class="px-4 py-3 text-xs text-right max-w-1">{{ $stat['defensive_rebounds'] }}</td>
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
