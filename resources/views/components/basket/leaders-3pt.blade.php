@php
    $standings = [
        [
            'name' => 'Team A',
            'played' => 10,
            'won' => 8,
            'lost' => 2,
            'points' => 18,
        ],
        [
            'name' => 'Team B',
            'played' => 10,
            'won' => 7,
            'lost' => 3,
            'points' => 17,
        ],
        [
            'name' => 'Team C',
            'played' => 10,
            'won' => 6,
            'lost' => 4,
            'points' => 16,
        ],
        [
            'name' => 'Team D',
            'played' => 10,
            'won' => 5,
            'lost' => 5,
            'points' => 15,
        ],
        [
            'name' => 'Team E',
            'played' => 10,
            'won' => 4,
            'lost' => 6,
            'points' => 14,
        ],
        [
            'name' => 'Team F',
            'played' => 10,
            'won' => 3,
            'lost' => 7,
            'points' => 13,
        ],
        [
            'name' => 'Team G',
            'played' => 10,
            'won' => 2,
            'lost' => 8,
            'points' => 12,
        ],
        [
            'name' => 'Team H',
            'played' => 10,
            'won' => 1,
            'lost' => 9,
            'points' => 11,
        ],
    ];
@endphp

<div class="{{ $class ?? '' }}">
    <x-ui.h2-double sub="Trice">Najbolji u tricama</x-ui.h2-double>

    <x-ui.card class="overflow-x-auto">
        <table class="table-auto w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider">U</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider">POB</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider">POR</th>
                    <th class="px-6 py-4 font-medium text-gray-500 uppercase tracking-wider text-right">BOD</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($standings as $position => $team)
                    <x-basket.leaders-3pt-item :position="$position" :team="$team" />
                @endforeach
            </tbody>
        </table>
    </x-ui.card>
</div>
