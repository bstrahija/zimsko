@extends('layouts.app')

@section('content')
    <div>
        <x-global.hero />

        <section class="mb-16 md:mb-24 lg:mb-32 wrapper">
            @livewire('widgets.live-score')

            <div class="grid grid-cols-1 gap-10 xl:grid-cols-3 lg:gap-10 xl:gap-10">
                <x-games.results-widget :games="$latestGames" />
                <x-games.schedule-widget :games="$upcomingGames" />
                <x-leaderboards.leaderboard-widget :leaderboard="$leaderboard" />
            </div>
        </section>

        <section class="pt-24 pb-24 mb-16 bg-center bg-cover md:pt-30 md:pb-32 md:mb-24 lg:mb-32" style="background-image: url('{{ asset('img/bg2.jpg') }}');">
            <div class="wrapper">
                <div class="flex justify-center items-center mb-10 text-center">
                    <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                        <img src="{{ asset('img/logo_ice.png') }}" alt="Ice Logo" class="w-auto h-16">
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-10 xl:gap-10">
                    <x-leaderboards.points-widget :leaderboard="$leaderboardPoints" />
                    <x-leaderboards.three-points-widget :leaderboard="$leaderboard3Point" />
                    <x-games.slideshow-widget />
                    {{-- <x-global.merch-widget /> --}}
                </div>
            </div>
        </section>

        <section class="wrapper">
            <x-global.latest-articles :articles="$latestArticles" />
        </section>
    </div>
@endsection
