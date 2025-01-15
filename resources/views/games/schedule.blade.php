@extends('layouts.app')

@section('content')
    <x-header title="Raspored" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-4">
                    <h1 class="mb-4 text-2xl font-bold text-center font-condensed text-secondary md:text-3xl">
                        Nadolazeće utakmice
                    </h1>

                    @if (!$games || !count($games))
                        <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
                            Nisu pronađene utakmice
                        </div>
                    @else
                        @foreach ($games as $game)
                            <x-ui.card>
                                <div class="flex flex-col pt-2">
                                    <div class="flex flex-col items-center mb-4 sm:flex-row sm:justify-between">
                                        <div class="flex flex-col items-center mb-4 sm:w-1/4 sm:mb-0">
                                            <a href="{{ route('teams.show', $game->homeTeam->slug) }}" class="mb-2">
                                                <img src="{{ $game->homeTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20"
                                                    alt="{{ $game->homeTeam->title }}">
                                            </a>
                                            <a href="{{ route('teams.show', $game->homeTeam->slug) }}"
                                                class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->homeTeam->title }}</a>
                                        </div>

                                        <div class="flex flex-col items-center mb-4 sm:w-2/4 sm:mb-0">
                                            <div class="mb-2 text-sm text-gray-500">
                                                <h2 class="mb-1 font-bold text-center">{{ $game->title }}</h2>
                                                <small class="block text-center">{{ $game->scheduled_at->format('d.m.Y. H:i') }}</small>
                                            </div>
                                            <div class="mb-2 text-3xl font-bold sm:text-4xl">
                                                <span class="text-gray-500">0</span>
                                                <span class="mx-2 text-gray-400">-</span>
                                                <span class="text-gray-500">0</span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-center sm:w-1/4">
                                            <a href="{{ route('teams.show', $game->awayTeam->slug) }}" class="mb-2">
                                                <img src="{{ $game->awayTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20"
                                                    alt="{{ $game->awayTeam->title }}">
                                            </a>
                                            <a href="{{ route('teams.show', $game->awayTeam->slug) }}"
                                                class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->awayTeam->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            </x-ui.card>
                        @endforeach
                    @endif
                </div>

                <div class="mt-6">
                    {{ $games->links() }}
                </div>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
