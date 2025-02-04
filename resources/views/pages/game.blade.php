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
                        <x-games.stats :game="$game" :live="$live" />

                        <x-games.log-stream :game="$game" :live="$live" />
                    @else
                        <x-games.leaders :game="$game" :live="$live" :scorers="$scorers" />
                    @endif
                @endif
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4">

                {{-- <x-ui.card class="mb-8" title="{{ $game->title }}">
                    <a href="{{ route('reports.game', $game->slug) }}" target="_blank">Izvještaj</a>
                </x-ui.card> --}}
            </x-global.sidebar>
        </div>
    </div>
@endsection
