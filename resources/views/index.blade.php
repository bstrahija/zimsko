@extends('layouts.app')

@section('content')
    <x-hero />

    <div class="container">
        <x-basket.latest-results />

        <hr class="my-12">

        <div class="grid grid-cols-12 gap-12">
            <x-basket.upcoming-games class="col-span-8" />
            <x-basket.leaderboard class="col-span-4" />
        </div>

        <div class="grid grid-cols-12 gap-12">
            <div class="col-span-8 space-y-12">

                <h1>Čakovec</h1>
                <x-ui.button variant="primary">Primary</x-ui.button>
                <x-ui.button variant="secondary">Secondary</x-ui.button>
                <x-ui.button variant="accent">Accent</x-ui.button>
                <x-ui.button>Default</x-ui.button>
                <hr>
                <x-ui.input id="input-01" placeholder="Email" type="email" />
                <x-ui.textarea id="textarea-01" placeholder="Leave a comment" />
            </div>

            <div class="col-span-4">
                <livewire:live-score />

                <x-basket.standings />
            </div>
        </div>
    </div>
@endsection
