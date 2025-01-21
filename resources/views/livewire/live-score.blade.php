<div>
    @if ($game)
        <div class="relative pt-10 pb-11 mb-12 bg-center bg-no-repeat bg-cover bg-gradient-to-br rounded-sm rounded-t shadow-sm md:pt-6 live-score-widget from-secondary/95 to-secondary/70"
            style="background-image: url('{{ asset('img/bg2.jpg') }}');">
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full animate-pulse">
                    LIVE
                </span>
            </div>

            <h2 class="mb-6 text-xl font-bold text-center drop-shadow font-condensed text-white/90">{{ $game->title }}</h2>

            <div class="grid grid-cols-2 gap-8 mb-8 w-full lg:gap-10 text-white/90">
                <div class="flex overflow-hidden flex-col gap-6 justify-between items-center w-full lg:flex lg:flex-row bg-white/90">
                    <div class="flex flex-col items-center pt-4 lg:flex-row lg:px-6">
                        <p class="px-2 py-2 text-center team-logo">
                            <img src="{{ $game->homeTeam->logo() }}" alt="" class="rounded-full size-10">
                        </p>
                        <h2 class="px-4 py-2 text-lg font-bold text-center drop-shadow md:text-3xl text-black/80 font-heading lg:whitespace-nowrap">
                            {{ $game->homeTeam->title }}
                        </h2>
                    </div>
                    <p
                        class="flex justify-center items-center px-4 py-4 w-full h-full font-mono text-xl font-extrabold text-center border-t-4 drop-shadow-xl lg:px-12 lg:max-w-12 md:text-4xl bg-primary/80 border-primary">
                        {{ $game->home_score }}
                    </p>
                </div>

                <div class="flex overflow-hidden flex-col gap-6 justify-between items-center w-full bg-white/90 lg:flex lg:flex-row-reverse">
                    <div class="flex flex-col items-center pt-4 lg:flex-row-reverse lg:px-6">
                        <p class="px-2 py-2 text-center team-logo">
                            <img src="{{ $game->awayTeam->logo() }}" alt="" class="rounded-full size-10">
                        </p>
                        <h2 class="px-4 py-2 text-lg font-bold text-center drop-shadow md:text-3xl text-black/80 font-heading lg:whitespace-nowrap">
                            {{ $game->awayTeam->title }}
                        </h2>
                    </div>
                    <p
                        class="flex justify-center items-center px-4 py-4 w-full h-full font-mono text-xl font-extrabold text-center border-t-4 drop-shadow-xl lg:px-12 lg:max-w-12 md:text-4xl bg-primary/80 border-primary">
                        {{ $game->away_score }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 px-8 mx-auto max-w-4xl xl md:gap-8 lg:gap-10 md:grid-cols-4">
                @foreach (range(1, 4) as $quarter)
                    <div class="bg-white/90">
                        <h3
                            class="text-xs md:text-sm bg-primary/80 font-heading text-center text-white/90 px-4 py-2 border-t-4 border-primary {{ $game->period === $quarter ? 'animate-pulse' : '' }} {{ $game->period !== $quarter ? ($game->period > $quarter ? ' grayscale opacity-50' : 'opacity-50 border-secondary bg-secondary/90') : '' }}">
                            Q{{ $quarter }}
                        </h3>
                        <div class="px-5 py-3 font-mono font-bold text-center whitespace-nowrap lg:py-6 text-md md:text-xl xl:text-2xl text-black/80">
                            <span>{{ $game->{'home_score_p' . $quarter} }}</span>
                            <span>:</span>
                            <span>{{ $game->{'away_score_p' . $quarter} }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="mb-12">
    @endif
</div>
