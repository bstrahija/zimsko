<table class="w-full text-sm table-auto">
    <thead>
        <tr class="border-b border-gray-200">
            <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase"></th>
            <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Broj</th>
            <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Pozicija</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach ($team->activePlayers as $player)
            <tr class="hover:bg-gray-100">
                <td class="px-2 py-3">
                    <a href="{{ route('players.show', $player->slug) }}" class="flex items-center">
                        <img src="{{ $player->photo() ?: $team->logo() }}" alt="{{ $player->name }}" class="mr-3 w-8 h-8 rounded-full">
                        <span class="font-medium text-gray-900">{{ $player->name }}</span>
                    </a>
                </td>
                <td class="px-2 py-3 text-right text-gray-500">{{ $player->number }}</td>
                <td class="px-2 py-3 text-right text-gray-500">{{ strtoupper($player->position) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
