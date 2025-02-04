<x-ui.card class="mb-8 col" title="Statistika" subtitle="Kompletna statistika tokom utakmice">
    <div x-data="{ activeTab: 'team' }" class="mb-6">
        <div class="flex overflow-x-auto flex-wrap">
            @php
                $tabs = [
                    'team' => 'Ekipe',
                    'score' => 'Poeni',
                    '3pt' => '3PT',
                    'fg' => 'FG',
                    'ft' => 'FT',
                    'ast' => 'AST',
                    'reb' => 'REB',
                    'stl' => 'STL',
                    'blk' => 'BLK',
                    'foul' => 'FOULS',
                    'to' => 'TO',
                    'eff' => 'EFF',
                ];
            @endphp
            @foreach ($tabs as $key => $label)
                <button @click="activeTab = '{{ $key }}'"
                    :class="{ 'border-primary': activeTab === '{{ $key }}', 'border-transparent': activeTab !== '{{ $key }}' }"
                    class="px-3 py-2 text-xs font-medium text-gray-600 whitespace-nowrap border-b-2 sm:text-sm hover:text-gray-800">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div x-show="activeTab === 'team'" class="mt-4">
            <x-live.team-stats :game="$live" />
        </div>

        <div x-show="activeTab === 'score'" class="mt-4">
            <x-live.player-stats type="score" :game="$live" />
        </div>

        <div x-show="activeTab === '3pt'" class="mt-4">
            <x-live.player-stats type="three_points" :game="$live" />
        </div>

        <div x-show="activeTab === 'fg'" class="mt-4">
            <x-live.player-stats type="field_goals" :game="$live" />
        </div>

        <div x-show="activeTab === 'ft'" class="mt-4">
            <x-live.player-stats type="free_throws" :game="$live" />
        </div>

        <div x-show="activeTab === 'ast'" class="mt-4">
            <x-live.player-stats type="assists" :game="$live" />
        </div>

        <div x-show="activeTab === 'reb'" class="mt-4">
            <x-live.player-stats type="rebounds" :game="$live" />
        </div>

        <div x-show="activeTab === 'stl'" class="mt-4">
            <x-live.player-stats type="steals" :game="$live" />
        </div>

        <div x-show="activeTab === 'blk'" class="mt-4">
            <x-live.player-stats type="blocks" :game="$live" />
        </div>

        <div x-show="activeTab === 'foul'" class="mt-4">
            <x-live.player-stats type="fouls" :game="$live" />
        </div>

        <div x-show="activeTab === 'to'" class="mt-4">
            <x-live.player-stats type="turnovers" :game="$live" />
        </div>

        <div x-show="activeTab === 'eff'" class="mt-4">
            <x-live.player-stats type="efficiency" :game="$live" />
        </div>
    </div>
</x-ui.card>
