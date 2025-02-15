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
                        <x-teams.team-stats :stats="$teamStats" :team="$team" />
                    </x-ui.card>

                    <x-ui.card class="mb-8 card" title="Igrači" subtitle="Svi igrači u ekipi">
                        <x-teams.player-stats :stats="$playerStats" :team="$team" />
                    </x-ui.card>

                    <x-games.team-latest-games-column :team="$team" :games="$latestGames" />

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
