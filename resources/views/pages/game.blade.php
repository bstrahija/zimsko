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

                    <x-games.stats :game="$game" :live="$live" />

                    <x-games.log-stream :game="$game" :live="$live" />
                @endif
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
