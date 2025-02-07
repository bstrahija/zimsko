<tr class="border-b hover:bg-gray-100">
    <td class="px-2 py-5">
        <a href="{{ route('players.show', $item->player->slug ?? ($item->player->team->slug ?? '')) }}" class="flex gap-2 items-center text-xs">
            <small class="mr-3 text-gray-500">{{ $position + 1 }}</small>

            @if ($item->player->photo())
                <span class="inline-flex overflow-hidden justify-center items-center w-8 h-8 bg-center bg-no-repeat bg-cover rounded-full"
                    style="background-image: url('{{ $item->player->photo() ?: $item->team->logo() }}');">
                </span>
            @else
                <span class="inline-flex justify-center items-center w-8 h-8">
                    <img src="{{ $item->team->logo() }}" alt="" class="max-w-full max-h-full">
                </span>
            @endif

            <span class="text-gray-800 whitespace-nowrap">{{ $item->title }}</span>
        </a>
    </td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->games }}</td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->three_points_made }}</td>
    <td class="px-2 py-5 text-xs font-bold text-right">{{ round($item->three_points_made_avg, 1) }}</td>
</tr>
