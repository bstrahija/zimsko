@extends('layouts.app')

@section('content')
    <x-hero />

    <div class="mb-24 wrapper">
        <livewire:live-score />

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-6 xl:gap-8">
            <x-basket.latest-results :games="$latestGames" />
            <x-basket.upcoming-games :games="$upcomingGames" />
            <x-basket.leaderboard :leaderboard="$leaderboard" />
        </div>
    </div>

    <div class="pt-10 pb-16 mb-24 bg-center bg-cover wrapper" style="background-image: url('{{ asset('img/bg2.jpg') }}');">
        <div class="flex justify-center items-center mb-10 text-center">
            <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                <img src="{{ asset('img/logo_ice.png') }}" alt="Ice Logo" class="w-auto h-16">
            </a>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-6 xl:gap-8">
            <x-basket.leaders :leaderboard="$leaderboardPoints" />
            <x-basket.leaders-3pt :leaderboard="$leaderboard3Point" />
            <x-basket.slideshow />
        </div>
    </div>

    <div class="wrapper">
        <x-latest-articles :articles="$latestArticles" />
    </div>
@endsection
