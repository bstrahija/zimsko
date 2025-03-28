@php
    if (!isset($stats)) {
        $homeStats = \App\Models\Stat::where('team_id', $game->home_team_id)->where('for', 'team')->where('type', 'event')->where('event_id', $game->event_id)->first();
        $awayStats = \App\Models\Stat::where('team_id', $game->away_team_id)->where('for', 'team')->where('type', 'event')->where('event_id', $game->event_id)->first();
    }
@endphp

<x-ui.card class="mb-8" title="Ekipe" subtitle="Statistika kroz turnir">
    @if ($homeStats && $awayStats)
        <div class="grid">
            <div class="grid grid-cols-2 pb-2 mb-3 border-b border-gray-300">
                <div class="flex text-lg font-bold text-left text-gray-700">
                    <span class="mr-2">
                        <img src="{{ $game->homeTeam->logo() }}" alt=""class="max-h-8 rounded-full max-w-8">
                    </span>
                    {{ $game->homeTeam->title }}
                </div>
                <div class="flex justify-end text-lg font-bold text-right text-gray-700">
                    {{ $game->awayTeam->title }}
                    <span class="ml-2">
                        <img src="{{ $game->awayTeam->logo() }}" alt=""class="max-h-8 rounded-full max-w-8">
                    </span>
                </div>
            </div>

            <div class="divide-gray-200 divide-y-[1px]">
                <div class="grid grid-cols-[1fr_70px_1fr] sm:grid-cols-[1fr_130px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm text-gray-700">{{ $homeStats->games }}</div>
                    <div class="text-xs text-center text-gray-700">Utakmice<br> ({{ App\Models\Event::current()->title }})</div>
                    <div class="relative text-sm text-right text-gray-700">{{ $awayStats->games }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] sm:grid-cols-[1fr_130px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeWins > $awayWins ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $homeWins }}</div>
                    <div class="text-xs text-center text-gray-700">Omjer ukupno</div>
                    <div class="relative text-sm text-right {{ $awayWins > $homeWins ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $awayWins }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] sm:grid-cols-[1fr_130px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->score > $awayStats->score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->games ? round($homeStats->score / $homeStats->games, 2) : 0 }}
                        <small>({{ round($homeStats->field_goals_percent, 1) }}%)</small>
                    </div>
                    <div class="text-xs text-center text-gray-700">PTS</div>
                    <div class="relative text-sm text-right {{ $awayStats->score > $homeStats->score ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->games ? round($awayStats->score / $awayStats->games, 2) : 0 }}
                        <small>({{ round($awayStats->field_goals_percent, 1) }}%)</small>
                    </div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->three_points_made > $awayStats->three_points_made ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->three_points_made }}/<small>{{ $homeStats->three_points }}
                            ({{ $homeStats->three_points_percent }}%)</small>
                    </div>
                    <div class="text-xs text-center text-gray-700">3PT</div>
                    <div
                        class="relative text-sm text-right {{ $awayStats->three_points_made > $homeStats->three_points_made ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->three_points_made }}/<small>{{ $awayStats->three_points }}
                            ({{ round($awayStats->three_points_percent, 1) }}%)</small>
                    </div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->free_throws_percent > $awayStats->free_throws_percent ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->free_throws_made }}/<small>{{ $homeStats->free_throws }}
                            ({{ $homeStats->free_throws_percent }}%)</small>
                    </div>
                    <div class="text-xs text-center text-gray-700">FT</div>
                    <div
                        class="relative text-sm text-right {{ $awayStats->free_throws_percent > $homeStats->free_throws_percent ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->free_throws_made }}/<small>{{ $awayStats->free_throws }}
                            ({{ $awayStats->free_throws_percent }}%)</small>
                    </div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->assists > $awayStats->assists ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $homeStats->assists }}
                    </div>
                    <div class="text-xs text-center text-gray-700">AST</div>
                    <div class="relative text-sm text-right {{ $awayStats->assists > $homeStats->assists ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->assists }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->rebounds > $awayStats->rebounds ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $homeStats->rebounds }}
                    </div>
                    <div class="text-xs text-center text-gray-700">REB</div>
                    <div class="relative text-sm text-right {{ $awayStats->rebounds > $homeStats->rebounds ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->rebounds }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->blocks > $awayStats->blocks ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $homeStats->blocks }}</div>
                    <div class="text-xs text-center text-gray-700">BLK</div>
                    <div class="relative text-sm text-right {{ $awayStats->blocks > $homeStats->blocks ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->blocks }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->steals > $awayStats->steals ? 'text-green-600 font-semibold' : 'text-gray-500' }}">{{ $homeStats->steals }}</div>
                    <div class="text-xs text-center text-gray-700">STL</div>
                    <div class="relative text-sm text-right {{ $awayStats->steals > $homeStats->steals ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->steals }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->turnovers < $awayStats->turnovers ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->turnovers }}</div>
                    <div class="text-xs text-center text-gray-700">TO</div>
                    <div class="relative text-sm text-right {{ $awayStats->turnovers < $homeStats->turnovers ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->turnovers }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->personal_fouls < $awayStats->personal_fouls ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->personal_fouls }}</div>
                    <div class="text-xs text-center text-gray-700">FOUL</div>
                    <div class="relative text-sm text-right {{ $awayStats->personal_fouls < $homeStats->personal_fouls ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->personal_fouls }}</div>
                </div>
                <div class="grid grid-cols-[1fr_70px_1fr] px-2 py-2 transition-colors duration-200 hover:bg-gray-50">
                    <div class="relative text-sm {{ $homeStats->efficiency > $awayStats->efficiency ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $homeStats->efficiency }}</div>
                    <div class="text-xs text-center text-gray-700">EFF</div>
                    <div class="relative text-sm text-right {{ $awayStats->efficiency > $homeStats->efficiency ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                        {{ $awayStats->efficiency }}</div>
                </div>
            </div>
        </div>
    @else
        <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
            <p class="text-sm">Trenutno nema podataka.</p>
        </div>
    @endif
</x-ui.card>
