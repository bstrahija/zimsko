<div>
    @if ($game)
        <div class="relative pt-6 pb-11 mb-12 bg-center bg-no-repeat bg-cover bg-gradient-to-br rounded-sm rounded-t shadow-sm live-score-widget from-secondary/95 to-secondary/70"
            style="background-image: url('{{ asset('img/live_score.jpg') }}');">
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full animate-pulse">
                    LIVE
                </span>
            </div>

            <h2 class="mb-6 text-lg font-bold text-center font-heading text-black/80">{{ $game->title }}</h2>

            <div class="grid grid-cols-2 gap-10 mb-8 w-full text-white/90">
                <div class="flex gap-6 justify-between items-center w-full bg-white/90">
                    <p class="px-8 py-6 team-logo">
                        <img src="{{ $game->homeTeam->logo() }}" alt="" class="w-16 h-16 rounded-full">
                    </p>
                    <h2 class="px-8 py-6 text-3xl font-bold drop-shadow text-black/80 font-heading">
                        {{ $game->homeTeam->title }}
                    </h2>
                    <p class="flex items-center px-8 py-6 h-full font-mono text-4xl font-extrabold border-r-4 drop-shadow-xl bg-primary/80 border-primary">
                        {{ $game->home_score }}
                    </p>
                </div>

                <div class="flex gap-6 justify-between items-center w-full bg-white/90">
                    <p class="flex items-center px-8 py-6 h-full font-mono text-4xl font-extrabold border-l-4 drop-shadow-xl bg-primary/80 border-primary">
                        {{ $game->away_score }}
                    </p>
                    <h2 class="px-8 py-6 text-3xl font-bold drop-shadow text-black/80 font-heading">
                        {{ $game->awayTeam->title }}
                    </h2>
                    <p class="px-8 py-6 team-logo">
                        <img src="{{ $game->awayTeam->logo() }}" alt="" class="w-16 h-16 rounded-full">
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-10 mx-auto max-w-xl">
                @foreach (range(1, 4) as $quarter)
                    <div class="aspect-square bg-white/90">
                        <h3
                            class="text-sm bg-primary/80 font-heading text-center text-white/90 px-4 py-2 border-t-4 border-primary {{ $game->period !== $quarter ? ($game->period > $quarter ? 'grayscale opacity-50' : 'opacity-50') : '' }}">
                            Q{{ $quarter }}
                        </h3>
                        <div class="px-5 py-3 font-mono text-2xl font-bold text-center whitespace-nowrap text-black/80">
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
