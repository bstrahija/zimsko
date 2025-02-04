@extends('layouts.app')

@section('content')
    @if ($team->photo())
        <x-header-photo title="{{ $team->title }}" url="{{ $team->photo('original') }}" />
    @else
        <x-header title="{{ $team->title }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-4">
                    @if ($nextGame)
                        <x-ui.card class="mb-8" title="Slijedeća utakmica">
                            <x-basket.game-details :game="$nextGame" />
                        </x-ui.card>
                    @endif

                    <x-ui.card class="overflow-x-auto mb-8" title="Poeni" subtitle="Povijest poena tokom svih utakmica">
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

                            <?php foreach ($team->completedGames()->get() as $game) : ?>
                            window.globalChartData.labels.push("<?php echo Str::limit($game->title, 40); ?>");
                            window.globalChartData.datasets[0].data.push("<?php echo $game->home_team_id === $team->id ? $game->home_score : $game->away_score; ?>");

                            <?php endforeach; ?>
                        </script>
                    </x-ui.card>

                    <x-ui.card class="overflow-x-auto" title="Igrači">
                        <table class="w-full text-sm table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase"></th>
                                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Broj</th>
                                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Pozicija</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($team->activePlayers as $player)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-2 py-3">
                                            <a href="{{ route('teams.players.show', $player->slug) }}" class="flex items-center">
                                                <img src="{{ $player->photo() ?: $team->logo() }}" alt="{{ $player->name }}" class="mr-3 w-8 h-8 rounded-full">
                                                <span class="font-medium text-gray-900">{{ $player->name }}</span>
                                            </a>
                                        </td>
                                        <td class="px-2 py-3 text-right text-gray-500">{{ $player->number }}</td>
                                        <td class="px-2 py-3 text-right text-gray-500">{{ strtoupper($player->position) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-ui.card>
                </div>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8" title="{{ $team->title }}" icon="{{ $team->logo('original') }}">
                    <a href="{{ $team->photo('original') }}" target="_blank" class="lightbox" data-pswp-width="{{ $team->photoSize('w') }}"
                        data-pswp-height="{{ $team->photoSize('h') }}">
                        <img src="{{ $team->photo('original') }}" alt="{{ $team->title }}" class="w-full">
                    </a>

                    <table class="mt-8 w-full text-xs text-left">
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Utakmica:</th>
                            <td class="py-2">{{ $team->gameCount() }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Utakmica (Zimsko 2025):</th>
                            <td class="py-2">{{ $team->gameCountCurrent() }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Prosjek:</th>
                            <td class="py-2">{{ $team->pointsAverage() }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <th class="py-2">Prosjek (Zimsko 2025):</th>
                            <td class="py-2">{{ $team->pointsAverageCurrent() }}</td>
                        </tr>
                    </table>
                </x-ui.card>

                @if ($lastGame)
                    <x-ui.card class="mb-8" title="Posljednja utakmica">
                        <x-basket.game-details :game="$lastGame" />
                    </x-ui.card>
                @endif
            </x-sidebar>
        </div>
    </div>
@endsection
