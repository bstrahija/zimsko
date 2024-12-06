<tr class="border-b hover:bg-gray-100">
    <td class="px-2 py-5">
        <a href="#" class="flex gap-2 items-center text-xs">
            <small class="mr-3 text-gray-500">{{ $position + 1 }}</small>
            <img src="{{ $item->player->photo() ?: $item->team->logo() }}" alt="{{ $item->team->title }}"
                class="w-8 h-8 rounded-full">
            <span class="text-gray-800 whitespace-nowrap">{{ $item->title }}</span>
        </a>
    </td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->games }}</td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->points }}</td>
    <td class="px-2 py-5 text-xs font-bold text-right">{{ round($item->avg, 1) }}</td>
</tr>
