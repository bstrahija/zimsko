@extends('layouts.app')

@section('content')
    <x-hero />

    <div class="container">
        <livewire:live-score />

        <x-basket.latest-results :latestGames="$latestGames" />

        <hr class="my-12">

        <div class="grid grid-cols-12 gap-12">
            <x-basket.leaderboard :leaderboard="$leaderboard" class="col-span-4" />
            <x-basket.leaders :leaderboard="$leaderboardPoints" class="col-span-4" />
            <x-basket.leaders-3pt :leaderboard="$leaderboard3Point" class="col-span-4" />
            <x-basket.upcoming-games class="col-span-6" :games="$upcomingGames" />
        </div>

        <hr class="my-12">

        <x-sponsors />

        {{-- <div class="grid grid-cols-12 gap-12">
            <div class="col-span-8 space-y-12">

                <h1>Čakovec</h1>
                <hr>

                @php
                    $variants = ['primary', 'secondary', 'accent', 'success', 'error', 'dark', 'info', null];
                    $sizes = ['xs', 'sm', 'default', 'lg', 'xl', '2xl'];
                @endphp

                @foreach ($sizes as $size)
                    @foreach ($variants as $variant)
                        <x-ui.button variant="{{ $variant }}" size="{{ $size }}">
                            {{ ucfirst($variant ?? 'Default') }} <small>({{ $size }})</small>
                        </x-ui.button>
                    @endforeach
                    <hr>
                @endforeach

                <x-ui.input id="input-01" placeholder="Email" type="email" />
                <x-ui.textarea id="textarea-01" placeholder="Leave a comment" />
            </div>

            <div class="col-span-4">

            </div>
        </div> --}}
    </div>
@endsection
