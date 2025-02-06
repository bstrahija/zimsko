<x-ui.card class="mb-8 col" title="Ekipe" subtitle="Vodeće ekipe tokom turnira">
    <div x-data="{ activeTab: 'score' }" class="mb-6">
        <div class="flex overflow-x-auto flex-wrap">
            @php
                $tabs = [
                    'score' => 'Poeni',
                    'three_points' => '3PT',
                    'field_goals' => 'FG',
                    'free_throws' => 'FT',
                    'assists' => 'AST',
                    'rebounds' => 'REB',
                    'steals' => 'STL',
                    'blocks' => 'BLK',
                    'fouls' => 'FOULS',
                    'turnovers' => 'TO',
                    'efficiency' => 'EFF',
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

        <div x-show="activeTab === 'score'" class="mt-4">
            <x-stats.teams-tab type="score" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'three_points'" class="mt-4">
            <x-stats.teams-tab type="three_points" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'field_goals'" class="mt-4">
            <x-stats.teams-tab type="field_goals" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'free_throws'" class="mt-4">
            <x-stats.teams-tab type="free_throws" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'assists'" class="mt-4">
            <x-stats.teams-tab type="assists" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'rebounds'" class="mt-4">
            <x-stats.teams-tab type="rebounds" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'steals'" class="mt-4">
            <x-stats.teams-tab type="steals" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'blocks'" class="mt-4">
            <x-stats.teams-tab type="blocks" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'fouls'" class="mt-4">
            <x-stats.teams-tab type="fouls" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'turnovers'" class="mt-4">
            <x-stats.teams-tab type="turnovers" :stats="$stats" />
        </div>

        <div x-show="activeTab === 'efficiency'" class="mt-4">
            <x-stats.teams-tab type="efficiency" :stats="$stats" />
        </div>
    </div>
</x-ui.card>
