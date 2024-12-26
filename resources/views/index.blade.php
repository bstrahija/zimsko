@extends('layouts.app')

@section('content')
    <x-hero />

    <div class="container">
        <livewire:live-score />

        <x-basket.latest-results :latestGames="$latestGames" />

        <hr class="my-12">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-basket.leaderboard :leaderboard="$leaderboard" />
            <x-basket.leaders :leaderboard="$leaderboardPoints" />
            <x-basket.leaders-3pt :leaderboard="$leaderboard3Point" />
        </div>

        <x-basket.upcoming-games class="col-span-6" :games="$upcomingGames" />

        <hr class="my-12">

        <x-latest-articles />

        <hr class="my-12">

        <x-sponsors />
    </div>
@endsection
