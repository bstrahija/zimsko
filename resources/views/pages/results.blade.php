@extends('layouts.app')

@section('content')
    <x-global.header title="Rezultati" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                @livewire('game-results')
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
