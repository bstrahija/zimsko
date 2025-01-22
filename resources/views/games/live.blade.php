@extends('layouts.app')

@section('content')
    <x-header title="Rezultati" />

    <div class="wrapper">
        <livewire:live-game :game="$game" />
    </div>
@endsection
