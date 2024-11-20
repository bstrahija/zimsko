@php

@endphp

<div class="{{ $class ?? '' }}">
    <x-ui.h2-double sub="Ljestvica">Poredak ekipa</x-ui.h2-double>

    <x-ui.card class="overflow-x-auto px-4">
        <table class="table-auto w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-2 py-4 text-left font-medium text-gray-500 uppercase tracking-wider">Pozicija</th>
                    <th class="px-2 py-4 text-right font-medium text-gray-500 uppercase tracking-wider">U</th>
                    <th class="px-2 py-4 text-right font-medium text-gray-500 uppercase tracking-wider">P</th>
                    <th class="px-2 py-4 text-right font-medium text-gray-500 uppercase tracking-wider">I</th>
                    <th class="px-2 py-4 text-right font-medium text-gray-500 uppercase tracking-wider">K</th>
                    <th class="px-2 py-4 text-right font-medium text-gray-500 uppercase tracking-wider">B</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($leaderboard as $position => $item)
                    <x-basket.leaderboard-item :position="$position" :item="$item" />
                @endforeach
            </tbody>
        </table>
    </x-ui.card>
</div>
