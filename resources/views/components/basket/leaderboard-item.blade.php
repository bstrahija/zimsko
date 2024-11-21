<tr class="border-b hover:bg-gray-100">
    <td class="px-2 py-5">
        <a href="#" class="flex items-center gap-2 text-xs">
            <small class="text-gray-500 mr-3">{{ $position + 1 }}</small>
            <img src="{{ $item->team->logo() }}" alt="{{ $item->team->name }}" class="w-8 h-8 rounded-full">
            <span class="text-gray-800 whitespace-nowrap">{{ $item->title }}</span>
        </a>
    </td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->games }}</td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->wins }}</td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->losses }}</td>
    <td class="px-2 py-5 text-xs text-right">{{ $item->scoreDifference }}</td>
    <td class="px-2 py-5 text-xs text-right font-bold">{{ $item->points }}</td>
</tr>
