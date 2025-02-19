@foreach (['home', 'away'] as $side)
    <div class="overflow-x-auto mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-gray-700 border-collapse">
                <thead class="text-gray-700 uppercase bg-gray-100 text-xxs">
                    <tr>
                        <th scope="col" class="sticky left-0 z-10 px-2 py-3 bg-gray-100">{{ $game[$side . '_team']['title'] }}</th>
                        <th scope="col" class="px-2 py-3 text-center">FG</th>
                        <th scope="col" class="px-2 py-3 text-center">3PT</th>
                        <th scope="col" class="px-2 py-3 text-center">FT</th>
                        <th scope="col" class="px-2 py-3 text-center">OREB</th>
                        <th scope="col" class="px-2 py-3 text-center">DREB</th>
                        <th scope="col" class="px-2 py-3 text-center">REB</th>
                        <th scope="col" class="px-2 py-3 text-center">AST</th>
                        <th scope="col" class="px-2 py-3 text-center">STL</th>
                        <th scope="col" class="px-2 py-3 text-center">BLK</th>
                        <th scope="col" class="px-2 py-3 text-center">TO</th>
                        <th scope="col" class="px-2 py-3 text-center">PF</th>
                        <th scope="col" class="px-2 py-3 text-center">EFF</th>
                        <th scope="col" class="px-2 py-3 text-center">PTS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($game[$side . '_players'] as $index => $player)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b hover:bg-gray-100">
                            <td class="sticky left-0 z-10 px-2 py-2 font-medium text-gray-900 whitespace-nowrap {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <a href="{{ route('players.show', $player['slug']) }}">{{ $player['name'] }}
                            </td></a>
                            <td class="px-2 py-2 text-center text-nowrap">
                                {{ $game['player_stats']['player__' . $player['id']]['field_goals_made'] }}-{{ $game['player_stats']['player__' . $player['id']]['field_goals'] }}
                            </td>
                            <td class="px-2 py-2 text-center text-nowrap">
                                {{ $game['player_stats']['player__' . $player['id']]['three_points_made'] }}-{{ $game['player_stats']['player__' . $player['id']]['three_points'] }}
                            </td>
                            <td class="px-2 py-2 text-center text-nowrap">
                                {{ $game['player_stats']['player__' . $player['id']]['free_throws_made'] }}-{{ $game['player_stats']['player__' . $player['id']]['free_throws'] }}
                            </td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['offensive_rebounds'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['defensive_rebounds'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['rebounds'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['assists'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['steals'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['blocks'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['turnovers'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['fouls'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['efficiency'] }}</td>
                            <td class="px-2 py-2 text-center">{{ $game['player_stats']['player__' . $player['id']]['score'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="font-semibold bg-gray-100">
                    <tr>
                        <td class="sticky left-0 z-10 px-2 py-3 bg-gray-100">Total</td>
                        <td class="px-2 py-3 text-center text-nowrap">
                            {{ $game[$side . '_team']['stats']['field_goals_made'] }}-{{ $game[$side . '_team']['stats']['field_goals'] }}</td>
                        <td class="px-2 py-3 text-center text-nowrap">
                            {{ $game[$side . '_team']['stats']['three_points_made'] }}-{{ $game[$side . '_team']['stats']['three_points'] }}</td>
                        <td class="px-2 py-3 text-center text-nowrap">
                            {{ $game[$side . '_team']['stats']['free_throws_made'] }}-{{ $game[$side . '_team']['stats']['free_throws'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['offensive_rebounds'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['defensive_rebounds'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['rebounds'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['assists'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['steals'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['blocks'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['turnovers'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['fouls'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['efficiency'] }}</td>
                        <td class="px-2 py-3 text-center">{{ $game[$side . '_team']['stats']['score'] }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endforeach
