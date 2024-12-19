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

        <x-latest-articles />

        <hr class="my-12">

        <x-sponsors />
    </div>
@endsection
