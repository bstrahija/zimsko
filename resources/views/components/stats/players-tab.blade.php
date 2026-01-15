@props(['stats', 'type', 'teams' => [], 'sortMode' => 'percent'])

<div class="w-full overflow-x-auto">
    @if ($stats && count($stats) > 0)
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="border-b border-gray-200 bg-gray-50">
                <tr>
                    <th class="w-1 px-4 py-3 font-medium text-gray-500"></th>
                    <th class="w-[60%] py-3 pl-1 pr-4 font-medium text-gray-500">Igrač</th>

                    @if ($type === 'score')
                        <th wire:click="toggleSort('score', 'total')"
                            class="{{ $sortMode === 'total' ? 'text-primary' : '' }} cursor-pointer px-4 py-3 text-right font-medium text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center gap-1">
                                Ukupno
                                @if ($sortMode === 'total')
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </th>
                    @elseif (in_array($type, ['three_points', 'field_goals', 'free_throws']))
                        <th wire:click="toggleSort('{{ $type }}')"
                            class="{{ $sortMode === 'made' ? 'text-primary' : '' }} cursor-pointer px-4 py-3 text-right font-medium text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center gap-1">
                                Ukupno
                                @if ($sortMode === 'made')
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </th>
                    @else
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Ukupno</th>
                    @endif

                    @if ($type === 'rebounds')
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Obrana</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Napad</th>
                    @endif

                    @if ($type === 'score')
                        <th wire:click="toggleSort('score', 'avg')"
                            class="{{ $sortMode === 'avg' ? 'text-primary' : '' }} cursor-pointer px-4 py-3 text-right font-medium text-gray-500 hover:text-gray-800">
                            <span class="inline-flex items-center gap-1">
                                AVG
                                @if ($sortMode === 'avg')
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </th>
                    @elseif (in_array($type, ['three_points', 'free_throws', 'assists', 'steals', 'blocks', 'fouls', 'turnovers', 'rebounds']))
                        <th class="px-4 py-3 text-right font-medium text-gray-500">AVG</th>
                    @endif

                    @if (in_array($type, ['score', 'three_points', 'field_goals', 'free_throws']))
                        @if ($type === 'score')
                            <th wire:click="toggleSort('score', 'percent')"
                                class="{{ $sortMode === 'percent' ? 'text-primary' : '' }} cursor-pointer px-4 py-3 text-right font-medium text-gray-500 hover:text-gray-800">
                                <span class="inline-flex items-center gap-1">
                                    Postotak
                                    @if ($sortMode === 'percent')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </span>
                            </th>
                        @elseif (in_array($type, ['three_points', 'field_goals', 'free_throws']))
                            <th wire:click="toggleSort('{{ $type }}')"
                                class="{{ $sortMode === 'percent' ? 'text-primary' : '' }} cursor-pointer px-4 py-3 text-right font-medium text-gray-500 hover:text-gray-800">
                                <span class="inline-flex items-center gap-1">
                                    Postotak
                                    @if ($sortMode === 'percent')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </span>
                            </th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($stats as $index => $stat)
                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="px-2 py-3 text-sm font-semibold text-gray-600">{{ $index + 1 }}.</td>
                        <td class="py-3 pl-0 pr-4 text-xs">
                            <a href="{{ route('players.show', $stat['player_slug']) }}" class="flex items-center">
                                <div class="relative mr-3 h-10 w-10 flex-shrink-0">
                                    <img src="{{ $stat['player_photo'] }}"
                                        class="h-10 w-10 rounded-full border-2 border-white object-cover shadow-sm"
                                        alt="{{ $stat['player_name'] }}">
                                </div>
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
                            <td class="max-w-1 px-4 py-3 text-right text-xs">{{ $stat['offensive_rebounds'] ?? 0 }}
                            </td>
                            <td class="max-w-1 px-4 py-3 text-right text-xs">{{ $stat['defensive_rebounds'] ?? 0 }}
                            </td>
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
                                    {{ $stat['games'] ? number_format($stat[$type . '_made'] / $stat['games'], 1) : 0 }}
                                @else
                                    {{ $stat['games'] ? number_format($stat[$type] / $stat['games'], 1) : 0 }}
                                @endif
                            </td>
                        @endif

                        @if (in_array($type, ['score', 'three_points', 'field_goals', 'free_throws']))
                            <td class="max-w-1 text-nowrap px-4 py-3 text-right text-xs">
                                @if (isset($stat[$type . '_made']))
                                    {{ $stat[$type . '_made'] }}/{{ $stat[$type] }}
                                    <small>({{ $stat[$type . '_percent'] ?? 0 }}%)</small>
                                @else
                                    {{ $type === 'score' ? $stat['field_goals_percent'] ?? 0 : $stat[$type . '_percent'] ?? 0 }}%
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
