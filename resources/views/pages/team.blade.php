@extends('layouts.app')

@php
    if (!isset($lastGame)) {
        $lastGame = $team->games()->orderBy('scheduled_at', 'desc')->first();
    }
    if (!isset($nextGame)) {
        $nextGame = $team->games()->orderBy('scheduled_at', 'asc')->first();
    }
@endphp

@section('content')
    @if ($team->photo())
        <x-global.header-photo title="{{ $team->title }}" url="{{ $team->photo('original') }}" />
    @else
        <x-global.header title="{{ $team->title }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-4">
                    @if ($nextGame)
                        <x-ui.card class="mb-8" title="Slijedeća utakmica">
                            <x-games.details :game="$nextGame" />
                        </x-ui.card>
                    @endif

                    <x-ui.card class="mb-8 card" title="Statistika" subtitle="Statistika tokom turnira">
                        <table class="w-full text-sm text-left text-gray-700">
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">UTAKMICA:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800" colspan="2">
                                        {{ $teamStats['games'] }}
                                    </td>
                                </tr>
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <th class="px-4 py-3 text-sm">POENI:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['score_avg'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap">
                                        {{ $teamStats['field_goals_percent'] }}%
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">3PT:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['three_points_made'] }} / {{ $teamStats['three_points'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap">
                                        {{ $teamStats['three_points_percent'] }}%
                                    </td>
                                </tr>
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <th class="px-4 py-3 text-sm">FG:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['field_goals_made'] }} / {{ $teamStats['field_goals'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap">
                                        {{ $teamStats['field_goals_percent'] }}%
                                    </td>
                                </tr>
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <th class="px-4 py-3 text-sm">FT:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['free_throws_made'] }} / {{ $teamStats['free_throws'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap">
                                        {{ $teamStats['free_throws_percent'] }}%
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">AST:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['assists'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>AVG:</small> {{ $teamStats['assists_avg'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">REB:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['rebounds'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>O:</small> {{ $teamStats['defensive_rebounds'] }} /
                                        <small>D:</small> {{ $teamStats['offensive_rebounds'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">STL:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['steals'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>AVG:</small> {{ $teamStats['assists_avg'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">BLK:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['blocks'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>AVG:</small> {{ $teamStats['blocks_avg'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">FOUL:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['fouls'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>AVG:</small> {{ $teamStats['fouls_avg'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">TO:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800">
                                        {{ $teamStats['turnovers'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-nowrap w-[20%]">
                                        <small>AVG:</small> {{ $teamStats['turnovers_avg'] }}
                                    </td>
                                </tr>
                                <tr class="bg-gray-50 transition-colors duration-200 hover:bg-gray-100">
                                    <th class="px-4 py-3 text-sm">EFF:</th>
                                    <td class="px-4 py-3 text-sm font-semibold text-right text-gray-800" colspan="2">
                                        {{ $teamStats['efficiency'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </x-ui.card>

                    <x-ui.card class="mb-8 card" title="Igrači" subtitle="Svi igrači u ekipi">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-sm">#</th>
                                    <th class="px-4 py-3 text-sm">Igrač</th>
                                    <th class="px-4 py-3 text-sm text-right">POS</th>
                                    <th class="px-4 py-3 text-sm text-right">Poeni</th>
                                    <th class="px-4 py-3 text-sm text-right">EFF:</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($playerStats as $player)
                                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                                        <td class="px-2 py-3 w-1 text-sm">{{ $player['player_number'] }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('players.show', $player['player_slug']) }}" class="flex items-center">
                                                <img src="{{ $player['player_photo'] ?: $team->logo() }}" alt="Vedran Biševac" class="mr-3 w-8 h-8 rounded-full">
                                                <span class="font-medium text-gray-900">{{ $player['player_name'] }}</span>
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right">{{ strtoupper($player['player_position']) }}</td>
                                        <td class="px-4 py-3 text-sm text-right">
                                            {{ $player['score'] }}
                                            <small>({{ round(($player['field_goals'] ? $player['field_goals_made'] / $player['field_goals'] : 0) * 100, 1) }}%)</small>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-right">

                                            {{ $player['efficiency'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-ui.card>



                    {{-- <x-ui.card class="overflow-x-auto mb-8" title="Poeni" subtitle="Povijest poena tokom svih utakmica">
                        <x-charts.team-points :team="$team" />
                    </x-ui.card> --}}



                    {{-- <x-ui.card class="overflow-x-auto" title="Igrači">
                        <x-teams.players :team="$team" />
                    </x-ui.card> --}}
                </div>
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8" title="{{ $team->title }}" icon="{{ $team->logo('original') }}">
                    <x-teams.details :team="$team" />
                </x-ui.card>

                @if ($lastGame)
                    <x-ui.card class="mb-8" title="Posljednja utakmica">
                        <x-games.details :game="$lastGame" />
                    </x-ui.card>
                @endif
            </x-global.sidebar>
        </div>
    </div>
@endsection
