@extends('layouts.app')

@section('content')
    @if ($player->team?->photo())
        <x-header-photo title="{{ $player->name }}" url="{{ $player->team->photo('original') }}" />
    @else
        <x-header title="{{ $player->name }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-12">
                    <x-ui.card class="" title="Posljednja utakmica">
                        @if ($lastGame)
                            <x-basket.game-details :game="$lastGame" />
                        @else
                            <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
                                Nema utakmica.
                            </div>
                        @endif
                    </x-ui.card>

                    <x-ui.card class="" title="Poeni">
                        @php
                            $stats = \App\Models\Stat::where('player_id', $player->id)->where('for', 'player')->where('type', 'game')->with('game')->get();
                        @endphp

                        @if ($stats && $stats->count() > 0)
                            <canvas id="globalChartContainer">
                                ...
                            </canvas>
                            <script>
                                window.globalChartData = {
                                    labels: [],
                                    datasets: [{
                                        label: 'Poeni',
                                        data: [],
                                        borderWidth: 1,
                                    }]
                                };

                                <?php foreach ($stats as $stat) : ?>
                                window.globalChartData.labels.push("<?php echo Str::limit($stat?->game?->title, 40); ?>");
                                window.globalChartData.datasets[0].data.push("<?php echo $stat?->score; ?>");

                                <?php endforeach; ?>
                            </script>
                        @else
                            <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
                                Trenutno nema podataka.
                            </div>
                        @endif
                    </x-ui.card>
                </div>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8" title="{{ $player->name }}" subtitle="Informacije">
                    <div class="grid gap-4">
                        @if ($player->photo())
                            <div class="flex justify-center"><img src="{{ $player->photo('original') }}" alt="{{ $player->name }}" class="max-w-[160px] rounded-full"></div>
                        @endif

                        <table class="text-xs text-left">
                            <tr class="border-b border-gray-200">
                                <th class="py-2">Ekipa:</th>
                                <td class="py-2">
                                    <a href="{{ route('teams.show', $player->team->slug) }}" class="flex gap-2">
                                        <img src="{{ $player->team ? $player->team->logo('thumb') : '' }}" alt="" class="size-4">
                                        {{ $player->team ? $player->team->title : '-' }}
                                    </a>
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
            </x-sidebar>
        </div>
    </div>
@endsection
