<x-ui.card class="mb-8 col" title="Igrači" subtitle="Vodeći igrači tokom turnira">
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
            <x-stats.players-tab type="score" :stats="Arr::get($stats, 'score', [])" />
        </div>

        <div x-show="activeTab === 'three_points'" class="mt-4">
            <x-stats.players-tab type="three_points" :stats="Arr::get($stats, 'three_points', [])" />
        </div>

        <div x-show="activeTab === 'field_goals'" class="mt-4">
            <x-stats.players-tab type="field_goals" :stats="Arr::get($stats, 'field_goals', [])" />
        </div>

        <div x-show="activeTab === 'free_throws'" class="mt-4">
            <x-stats.players-tab type="free_throws" :stats="Arr::get($stats, 'free_throws', [])" />
        </div>

        <div x-show="activeTab === 'assists'" class="mt-4">
            <x-stats.players-tab type="assists" :stats="Arr::get($stats, 'assists', [])" />
        </div>

        <div x-show="activeTab === 'rebounds'" class="mt-4">
            <x-stats.players-tab type="rebounds" :stats="Arr::get($stats, 'rebounds', [])" />
        </div>

        <div x-show="activeTab === 'steals'" class="mt-4">
            <x-stats.players-tab type="steals" :stats="Arr::get($stats, 'steals', [])" />
        </div>

        <div x-show="activeTab === 'blocks'" class="mt-4">
            <x-stats.players-tab type="blocks" :stats="Arr::get($stats, 'blocks', [])" />
        </div>

        <div x-show="activeTab === 'fouls'" class="mt-4">
            <x-stats.players-tab type="fouls" :stats="Arr::get($stats, 'fouls', [])" />
        </div>

        <div x-show="activeTab === 'turnovers'" class="mt-4">
            <x-stats.players-tab type="turnovers" :stats="Arr::get($stats, 'turnovers', [])" />
        </div>

        <div x-show="activeTab === 'efficiency'" class="mt-4">
            <x-stats.players-tab type="efficiency" :stats="Arr::get($stats, 'efficiency', [])" />
        </div>
    </div>
</x-ui.card>
