@extends('layouts.app')

@section('content')
    @if ($player->team?->photo())
        <x-global.header-photo title="{{ $player->name }}" url="{{ $player?->team->photo('original') }}" />
    @else
        <x-global.header title="{{ $player->name }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-12">
                    <x-ui.card class="" title="Posljednja utakmica">
                        @if ($lastGame)
                            <x-games.details :game="$lastGame" />
                        @else
                            <div class="border-l-4 border-yellow-500 bg-yellow-100 p-4 text-yellow-700">
                                Nema utakmica.
                            </div>
                        @endif
                    </x-ui.card>

                    <livewire:player.stats :player="$player" />

                    {{-- <x-ui.card class="" title="Poeni">
                        <x-charts.player-points :player="$player" />
                    </x-ui.card> --}}
                </div>
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8" title="{{ $player->name }}" subtitle="Informacije">
                    <div class="grid gap-4">
                        @if ($player->photo())
                            <div class="flex justify-center"><img src="{{ $player->photo('original') }}"
                                    alt="{{ $player->name }}" class="max-w-[160px] rounded-full"></div>
                        @endif

                        <table class="text-left text-xs">
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Ekipa:</th>
                                <td class="py-2">
                                    @if ($player->team)
                                        <a href="{{ route('teams.show', $player->team->slug) }}" class="flex gap-2">
                                            <img src="{{ $player->team ? $player->team->logo('thumb') : '' }}"
                                                alt="" class="size-4">
                                            {{ $player->team ? $player->team->title : '-' }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Država:</th>
                                <td class="py-2">{{ $player->country ?: '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Starost:</th>
                                <td class="py-2">{{ $player->age ?: '-' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Utakmica:</th>
                                <td class="py-2">{{ $player->gameCount() }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Utakmica (Zimsko 2025):</th>
                                <td class="py-2">{{ $player->gameCountCurrent() }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Prosjek:</th>
                                <td class="py-2">{{ $player->pointsAverage() }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Prosjek (Zimsko 2025):</th>
                                <td class="py-2">{{ $player->pointsAverageCurrent() }}</td>
                            </tr>
                        </table>
                    </div>
                </x-ui.card>

                <x-achievements.achievements-widget class="mb-8" title="Dostignuća" :subtitle="$player->name"
                    :player="$player" />
            </x-global.sidebar>
        </div>
    </div>
@endsection
