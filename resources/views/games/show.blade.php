@extends('layouts.app')

@section('content')
    <x-header title="Rezultati" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <x-ui.card class="mb-8" title="Rezultat" subtitle="{{ $game->event->title }} | {{ $game->title }}">
                    <div class="flex flex-col pt-2" x-data="{ open: false }">
                        <div class="flex flex-col items-center mb-4 sm:flex-row sm:justify-between">
                            <div class="flex flex-col items-center mb-4 sm:w-1/4 sm:mb-0">
                                <a href="{{ route('teams.show', $game->homeTeam->slug) }}" class="mb-2">
                                    <img src="{{ $game->homeTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20" alt="{{ $game->homeTeam->title }}">
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
                                    <span class="{{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    <span class="mx-2 text-gray-400">-</span>
                                    <span class="{{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->away_score }}</span>
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

                        <div class="w-full">
                            <div class="mt-4">
                                <div class="grid grid-cols-2 gap-2 text-sm text-center sm:grid-cols-4 sm:gap-4">
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q1</div>
                                        <div>{{ $game->home_score_p1 }} - {{ $game->away_score_p1 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q2</div>
                                        <div>{{ $game->home_score_p2 }} - {{ $game->away_score_p2 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q3</div>
                                        <div>{{ $game->home_score_p3 }} - {{ $game->away_score_p3 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q4</div>
                                        <div>{{ $game->home_score_p4 }} - {{ $game->away_score_p4 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>

                <hr class="my-12">

                <x-ui.card class="mb-8" title="Najbolji strijelci">
                    @if ($scorers && $scorers->count())
                        <table class="w-full text-sm table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase">Igrač</th>
                                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">P</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($scorers as $position => $item)
                                    <x-basket.leaders-item :position="$position" :item="$item" :for="'game'" />
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="py-4 text-center text-gray-500">Trenutno nema podataka.</p>
                    @endif
                </x-ui.card>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
