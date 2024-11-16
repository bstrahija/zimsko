<tr class="border-b hover:bg-gray-100">
    <td class="px-4 py-4">
        <a href="#">
            <small class="text-gray-500 mr-3">{{ $position + 1 }}</small>
            <span class="font-bold">
                <svg class="inline-block w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                        stroke="#FF6B6B" stroke-width="2" />
                    <path d="M21 12H3" stroke="#4ECDC4" stroke-width="2" />
                    <path d="M12 21V3" stroke="#45B7D1" stroke-width="2" />
                    <path d="M4.92896 4.92896C8.83418 8.83418 15.1658 8.83418 19.0711 4.92896" stroke="#96CEB4"
                        stroke-width="2" />
                    <path d="M4.92896 19.0711C8.83418 15.1658 15.1658 15.1658 19.0711 19.0711" stroke="#FFEEAD"
                        stroke-width="2" />
                </svg>
                {{ $team['name'] }}
            </span>
        </a>
    </td>
    <td class="px-4 py-4">{{ $team['played'] }}</td>
    <td class="px-4 py-4">{{ $team['won'] }}</td>
    <td class="px-4 py-4">{{ $team['lost'] }}</td>
    <td class="px-4 py-4 text-right font-bold">{{ $team['points'] }}</td>
</tr>
