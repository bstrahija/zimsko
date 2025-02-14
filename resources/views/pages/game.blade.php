@extends('layouts.app')

@section('content')
    <x-global.header title="{{ $game->title }}" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                @if ($game->status === 'in_progress')
                    @livewire('live-game', ['game' => $game, 'live' => $live])
                @else
                    <x-games.score :game="$game" />

                    @if ($game->scheduled_at->year === 2025)
                        @if ($game->status === 'completed')
                            <x-games.stats :game="$game" :live="$live" />

                            <x-games.log-stream :game="$game" :live="$live" />
                        @else
                            <x-games.compare-teams :game="$game" :live="$live" :homeWins="$homeWins" :awayWins="$awayWins" />

                            <x-games.team-latest-games :game="$game" :live="$live" :homeGames="$homeGames" :awayGames="$awayGames" />
                        @endif
                    @else
                        <x-games.leaders :game="$game" :live="$live" :scorers="$scorers" />
                    @endif
                @endif
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4">
                @if ($game?->scheduled_at?->year === 2025 && $game->status === 'completed')
                    <x-ui.card class="mb-8" title="Izvještaj" subtitle="Rezultat i statistika">
                        <x-ui.button class="w-full" tag="a" size="lg" variant="primary" href="{{ route('reports.game', $game->slug) }}" target="_blank">
                            <svg class="inline-block mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd"></path>
                            </svg>

                            Pregled izvještaja
                        </x-ui.button>
                    </x-ui.card>
                @endif
            </x-global.sidebar>
        </div>
    </div>
@endsection
