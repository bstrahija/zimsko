@php
    $percent = $attributes->get('percent', false);

    $homeStat = $game['home_team']['stats'][$type];
    $homeStatMade = $percent ? $game['home_team']['stats'][$type . '_made'] : 0;
    $homeStatPercent = $percent && $homeStat ? round(($homeStatMade / $homeStat) * 100, 2) : null;
    $awayStat = $game['away_team']['stats'][$type];
    $awayStatMade = $percent ? $game['away_team']['stats'][$type . '_made'] : 0;
    $awayStatPercent = $percent && $awayStat ? round(($awayStatMade / $awayStat) * 100, 2) : null;

    // Let's calculate the bar widths
    $maxStat = max($homeStat, $awayStat);
    if ($percent) {
        $homeBarWidth = $maxStat ? round(($homeStatMade / $maxStat) * 100, 2) : 0;
        $awayBarWidth = $maxStat ? round(($awayStatMade / $maxStat) * 100, 2) : 0;
    } else {
        $homeBarWidth = $maxStat ? round(($homeStat / $maxStat) * 100, 2) : 0;
        $awayBarWidth = $maxStat ? round(($awayStat / $maxStat) * 100, 2) : 0;
    }
@endphp

<div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
    <div class="relative text-sm text-gray-700">
        @if ($percent)
            {{ $homeStatMade }}
            /
            {{ $homeStat }}
            <small>({{ $homeStatPercent ?: 0 }}%)</small>
        @else
            {{ $homeStat }}
        @endif
        <div class="flex justify-start mt-2">
            <div class="h-1 rounded-sm bg-primary/80" style="width: {{ $homeBarWidth }}%"></div>
        </div>
    </div>

    <div class="text-sm text-center text-gray-700">
        {{ $name }}
    </div>

    <div class="relative text-sm text-right text-gray-700">
        @if ($percent)
            {{ $awayStatMade }}
            /
            {{ $awayStat }}
            <small>({{ $awayStatPercent ?: 0 }}%)</small>
        @else
            {{ $awayStat }}
        @endif
        <div class="flex justify-end mt-2">
            <div class="h-1 rounded-sm bg-primary/80" style="width: {{ $awayBarWidth }}%"></div>
        </div>
    </div>
</div>
