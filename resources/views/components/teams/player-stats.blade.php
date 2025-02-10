<div x-data="{ activeTab: 'score' }" class="mb-6">
    <div class="flex overflow-x-auto flex-wrap">
        @php
            $tabs = [
                'score' => 'Igrači',
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
        <x-teams.player-stats-tab type="score" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'three_points'" class="mt-4">
        <x-teams.player-stats-tab type="three_points" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'field_goals'" class="mt-4">
        <x-teams.player-stats-tab type="field_goals" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'free_throws'" class="mt-4">
        <x-teams.player-stats-tab type="free_throws" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'assists'" class="mt-4">
        <x-teams.player-stats-tab type="assists" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'rebounds'" class="mt-4">
        <x-teams.player-stats-tab type="rebounds" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'steals'" class="mt-4">
        <x-teams.player-stats-tab type="steals" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'blocks'" class="mt-4">
        <x-teams.player-stats-tab type="blocks" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'fouls'" class="mt-4">
        <x-teams.player-stats-tab type="fouls" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'turnovers'" class="mt-4">
        <x-teams.player-stats-tab type="turnovers" :stats="$stats" :team="$team" />
    </div>

    <div x-show="activeTab === 'efficiency'" class="mt-4">
        <x-teams.player-stats-tab type="efficiency" :stats="$stats" :team="$team" />
    </div>
</div>
