@php
    if (!isset($leaderboard) || !$leaderboard) {
        $leaderboard = \App\Services\Helpers::leaderboard();
    }
@endphp

<div class="block lg:grid{{ $class ?? '' }}">
    <x-ui.card class="overflow-x-auto" title="Poredak ekipa" subtitle="{{ $currentEvent->title ?: 'Zimsko' }}" variant="cta">
        <table class="w-full text-sm table-auto">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase">Pozicija</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">U</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">P</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">I</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">K</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">B</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($leaderboard as $position => $item)
                    <tr class="hover:bg-gray-100">
                        <td class="px-2 py-5">
                            <a href="{{ route('teams.show', $item->team->slug) }}" class="flex gap-2 items-center text-xs">
                                <small class="mr-3 text-gray-500">{{ $position + 1 }}</small>
                                <img src="{{ $item->team->logo() }}" alt="{{ $item->team->title }}" class="w-8 h-8 rounded-full">
                                <span class="text-gray-800 whitespace-nowrap">{{ $item->title }}</span>
                            </a>
                        </td>
                        <td class="px-2 py-5 text-xs text-right">{{ $item->games }}</td>
                        <td class="px-2 py-5 text-xs text-right">{{ $item->wins }}</td>
                        <td class="px-2 py-5 text-xs text-right">{{ $item->losses }}</td>
                        <td class="px-2 py-5 text-xs text-right">{{ $item->scoreDifference }}</td>
                        <td class="px-2 py-5 text-xs font-bold text-right">{{ $item->points }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-ui.card>
</div>
