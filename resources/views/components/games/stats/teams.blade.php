<div class="grid">
    <div class="grid grid-cols-3 pb-2 mb-3 border-b border-gray-300">
        <div class="text-lg font-bold text-left text-gray-700">
            {{ $game['home_team']['title'] }}
        </div>
        <div class="text-lg font-bold text-center text-gray-700">

        </div>
        <div class="text-lg font-bold text-right text-gray-700">
            {{ $game['away_team']['title'] }}
        </div>
    </div>

    <div class="divide-gray-200 divide-y-[1px]">
        <x-games.stats.team-stat name="3PT" type="three_points" :game="$game" :percent="true" />
        <x-games.stats.team-stat name="FG" type="two_points" :game="$game" :percent="true" />
        <x-games.stats.team-stat name="FT" type="free_throws" :game="$game" :percent="true" />
        <x-games.stats.team-stat name="AST" type="assists" :game="$game" />
        <x-games.stats.team-stat name="REB" type="rebounds" :game="$game" />
        <x-games.stats.team-stat name="STL" type="steals" :game="$game" />
        <x-games.stats.team-stat name="BLK" type="blocks" :game="$game" />
        <x-games.stats.team-stat name="FOUL" type="fouls" :game="$game" />
        <x-games.stats.team-stat name="TO" type="turnovers" :game="$game" />
        <x-games.stats.team-stat name="EFF" type="efficiency" :game="$game" />
    </div>
</div>
