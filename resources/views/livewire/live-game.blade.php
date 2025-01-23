<div>
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
                        <div class="mb-2 text-center">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full animate-pulse">
                                LIVE
                            </span>
                        </div>
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
                        <img src="{{ $game->awayTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20" alt="{{ $game->awayTeam->title }}">
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

                        <!-- Also check for overtime -->
                        @if ($game->home_score_p5 || $game->away_score_p5)
                            <div class="p-2 bg-gray-100 rounded-md">
                                <div class="font-semibold">OT</div>
                                <div>{{ $game->home_score_p5 }} - {{ $game->away_score_p5 }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-ui.card>

    <x-ui.card class="mb-8 col max-h-[80vh] overflow-y-auto" title="Tijek utakmice" subtitle="Uživo">
        @foreach ($log as $item)
            <div class="p-3 mb-4 bg-gray-50 rounded-lg shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="flex justify-between text-sm text-gray-700">
                    <div>
                        <strong class="mr-2">
                            {{ $item['home_score'] }}
                            :
                            {{ $item['away_score'] }}
                        </strong>
                        {{ $item['message'] }}

                        @if ($item['type'] === 'game_starting_players')
                            @php
                                $homeStarting = $game->homePlayers->whereIn('id', $game->home_starting_players)->values();
                                $awayStarting = $game->awayPlayers->whereIn('id', $game->away_starting_players)->values();
                            @endphp

                            @if ($homeStarting)
                                <h3 class="mt-2 font-semibold">{{ $game->homeTeam->title }}</h3>
                                <ul class="text-xs">
                                    @foreach ($homeStarting as $player)
                                        <li>{{ $player->name }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($awayStarting)
                                <h3 class="mt-2 font-semibold">{{ $game->awayTeam->title }}</h3>
                                <ul class="text-xs">
                                    @foreach ($awayStarting as $player)
                                        <li>{{ $player->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </div>

                    <div>
                        @if ($item['period'] <= 4)
                            Četrtina: {{ $item['period'] }}
                        @else
                            Produžetak: {{ $item['period'] - 4 }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </x-ui.card>
</div>
