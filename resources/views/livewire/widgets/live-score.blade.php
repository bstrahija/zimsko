<div>
    @if ($game && is_a($game, \App\Models\Game::class))
        <div class="live-score-widget relative mb-12 rounded-sm rounded-t bg-gradient-to-br from-secondary/95 to-secondary/70 bg-cover bg-center bg-no-repeat pb-11 pt-10 shadow-sm md:pt-6"
            style="background-image: url('{{ asset('img/bg2.jpg') }}');">
            <div class="absolute right-2 top-2">
                <span
                    class="inline-flex animate-pulse items-center rounded-full bg-red-600 px-2 py-1 text-xs font-bold text-red-100">
                    LIVE
                </span>
            </div>

            <h2 class="mb-6 text-center font-condensed text-xl font-bold text-white/90 drop-shadow">{{ $game->title }}
            </h2>

            <div class="mb-8 grid w-full grid-cols-2 gap-8 text-white/90 lg:gap-10">
                <div
                    class="flex w-full flex-col items-center justify-between gap-6 overflow-hidden bg-white/90 lg:flex lg:flex-row">
                    <div class="flex flex-col items-center pt-4 lg:flex-row lg:px-6">
                        <p class="team-logo px-2 py-2 text-center">
                            <img src="{{ $game->homeTeam->logo() }}" alt="" class="size-10 rounded-full">
                        </p>
                        <h2
                            class="px-4 py-2 text-center font-heading text-lg font-bold text-black/80 drop-shadow md:text-3xl lg:whitespace-nowrap">
                            {{ $game->homeTeam->title }}
                        </h2>
                    </div>
                    <p
                        class="flex h-full w-full items-center justify-center border-t-4 border-primary bg-primary/80 px-4 py-4 text-center font-mono text-xl font-extrabold drop-shadow-xl md:text-4xl lg:max-w-12 lg:px-12">
                        {{ $game->home_score }}
                    </p>
                </div>

                <div
                    class="flex w-full flex-col items-center justify-between gap-6 overflow-hidden bg-white/90 lg:flex lg:flex-row-reverse">
                    <div class="flex flex-col items-center pt-4 lg:flex-row-reverse lg:px-6">
                        <p class="team-logo px-2 py-2 text-center">
                            <img src="{{ $game->awayTeam->logo() }}" alt="" class="size-10 rounded-full">
                        </p>
                        <h2
                            class="px-4 py-2 text-center font-heading text-lg font-bold text-black/80 drop-shadow md:text-3xl lg:whitespace-nowrap">
                            {{ $game->awayTeam->title }}
                        </h2>
                    </div>
                    <p
                        class="flex h-full w-full items-center justify-center border-t-4 border-primary bg-primary/80 px-4 py-4 text-center font-mono text-xl font-extrabold drop-shadow-xl md:text-4xl lg:max-w-12 lg:px-12">
                        {{ $game->away_score }}
                    </p>
                </div>
            </div>

            <div class="xl mx-auto grid max-w-4xl grid-cols-2 gap-8 px-8 md:grid-cols-4 md:gap-8 lg:gap-10">
                @foreach (range(1, 4) as $quarter)
                    <div class="bg-white/90">
                        <h3
                            class="{{ $game->period === $quarter ? 'animate-pulse' : '' }} {{ $game->period !== $quarter ? ($game->period > $quarter ? ' grayscale opacity-50' : 'opacity-50 border-secondary bg-secondary/90') : '' }} border-t-4 border-primary bg-primary/80 px-4 py-2 text-center font-heading text-xs text-white/90 md:text-sm">
                            Q{{ $quarter }}
                        </h3>
                        <div
                            class="text-md whitespace-nowrap px-5 py-3 text-center font-mono font-bold text-black/80 md:text-xl lg:py-6 xl:text-2xl">
                            <span>{{ $game->{'home_score_p' . $quarter} }}</span>
                            <span>:</span>
                            <span>{{ $game->{'away_score_p' . $quarter} }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-center">
                <x-ui.button tag="a" href="{{ route('games.show', $game->slug) }}" variant="primary">
                    🕗 Prati tijek
                </x-ui.button>
            </div>
        </div>

        <hr class="mb-12">
    @endif
</div>
