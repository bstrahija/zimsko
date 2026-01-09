@extends('layouts.app')

@section('content')
    <x-global.header title="Statistika" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <livewire:stats.team-stats />

                <livewire:stats.player-stats />

                <x-stats.officials :$officials />
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
