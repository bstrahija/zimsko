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

<x-ui.widget title="Ljestvica">
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Pos</th>
                    <th class="px-4 py-2">Team</th>
                    <th class="px-4 py-2">P</th>
                    <th class="px-4 py-2">W</th>
                    <th class="px-4 py-2">L</th>
                    <th class="px-4 py-2">PTS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($standings as $position => $team)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2 text-center">{{ $position + 1 }}</td>
                        <td class="px-4 py-2">{{ $team['name'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $team['played'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $team['won'] }}</td>
                        <td class="px-4 py-2 text-center">{{ $team['lost'] }}</td>
                        <td class="px-4 py-2 text-center font-bold">{{ $team['points'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-ui.widget>
