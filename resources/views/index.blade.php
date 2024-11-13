@extends('layouts.app')

@section('content')
    <x-hero />

    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-8">
                <h1>Čakovec</h1>
                <x-ui.btn variant="primary">Primary</x-ui.btn>
                <x-ui.btn variant="secondary">Secondary</x-ui.btn>
                <x-ui.btn variant="accent">Accent</x-ui.btn>
                <x-ui.btn>Default</x-ui.btn>
            </div>
            <div class="col-span-4">
                <livewire:live-score />

                <x-basket.standings />
            </div>
        </div>


    </div>
@endsection
