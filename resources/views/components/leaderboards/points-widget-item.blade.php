@php
    $for = $for ?? 'event';
@endphp

<tr class="border-b hover:bg-gray-100">
    <td class="px-2 py-5">
        <a href="{{ route('players.show', $item->player->slug ?? ($item->player->team->slug ?? '')) }}" class="flex gap-2 items-center text-xs">
            <small class="mr-3 text-gray-500">{{ $position + 1 }}</small>

            <x-global.player-photo-for-tables :playerPhoto="$item->player->photo()" :teamLogo="$item->team->logo()" />

            <span class="text-gray-800 whitespace-nowrap">{{ $item->title }}</span>
        </a>
    </td>
    @if ($for !== 'game')
        <td class="px-2 py-5 text-xs text-right">{{ $item->games }}</td>
    @endif

    <td class="px-2 py-5 text-xs text-right">{{ $item->score }}</td>

    @if ($for !== 'game')
        <td class="px-2 py-5 text-xs font-bold text-right">{{ round($item->score_avg, 1) }}</td>
    @endif
</tr>
