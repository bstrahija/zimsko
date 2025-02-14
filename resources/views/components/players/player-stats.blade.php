<table class="w-full text-sm text-left text-gray-700">
    <tbody class="divide-y divide-gray-100">
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-200">
            <th class="px-4 py-3 text-sm">UTAKMICA:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800" colspan="2">
                {{ $stats['games'] }}
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">POENI:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['score'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap">
                {{ $stats['field_goals_percent'] }}%
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">PROSJEK:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['score_avg'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap">
                {{ $stats['field_goals_percent'] }}%
            </td>
        </tr>
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
            <th class="px-4 py-3 text-sm">3PT:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['three_points_made'] }} / {{ $stats['three_points'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap">
                {{ $stats['three_points_percent'] }}%
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">FG:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['field_goals_made'] }} / {{ $stats['field_goals'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap">
                {{ $stats['field_goals_percent'] }}%
            </td>
        </tr>
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-10">
            <th class="px-4 py-3 text-sm">FT:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['free_throws_made'] }} / {{ $stats['free_throws'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap">
                {{ $stats['free_throws_percent'] }}%
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">AST:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['assists'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>AVG:</small> {{ $stats['assists_avg'] }}
            </td>
        </tr>
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
            <th class="px-4 py-3 text-sm">REB:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['rebounds'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>O:</small> {{ $stats['defensive_rebounds'] }} /
                <small>D:</small> {{ $stats['offensive_rebounds'] }}
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">STL:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['steals'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>AVG:</small> {{ $stats['assists_avg'] }}
            </td>
        </tr>
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
            <th class="px-4 py-3 text-sm">BLK:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['blocks'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>AVG:</small> {{ $stats['blocks_avg'] }}
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">FOUL:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['fouls'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>AVG:</small> {{ $stats['fouls_avg'] }}
            </td>
        </tr>
        <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
            <th class="px-4 py-3 text-sm">TO:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                {{ $stats['turnovers'] }}
            </td>
            <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                <small>AVG:</small> {{ $stats['turnovers_avg'] }}
            </td>
        </tr>
        <tr class="transition-colors duration-200 hover:bg-gray-50">
            <th class="px-4 py-3 text-sm">EFF:</th>
            <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800" colspan="2">
                {{ $stats['efficiency'] }}
            </td>
        </tr>
    </tbody>
</table>
