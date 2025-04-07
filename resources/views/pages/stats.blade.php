@extends('layouts.app')

@section('content')
    <x-global.header title="Statistika" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <x-stats.team-stats :stats="$teamStats" :teams="$teams" />

                <x-stats.player-stats :stats="$playerStats" :teams="$teams" />

                <x-stats.officials :$officials />
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
