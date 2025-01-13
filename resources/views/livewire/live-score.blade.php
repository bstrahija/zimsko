<div>
    @if ($game && $live)
        <div class="relative pt-6 pb-11 mb-12 rounded-sm shadow-sm live-score-widget">
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full animate-pulse">
                    LIVE
                </span>
            </div>

            <h2 class="mb-6 text-lg font-bold font-oswald text-black/80">{{ $game->title }}</h2>

            <div class="grid grid-cols-2 gap-10 mb-8 w-full text-white/90">
                <div class="flex gap-6 justify-between items-center w-full bg-white/90">
                    <p class="px-8 py-6 team-logo">
                        <img src="{{ $live['away_team']['logo'] }}" alt="" class="w-12 h-12 rounded-full">
                    </p>
                    <h2 class="px-8 py-6 text-2xl font-bold drop-shadow text-black/80 font-oswald">
                        {{ $live['home_team']['title'] }}
                    </h2>
                    <p class="text-4xl px-8 py-6 font-extrabold drop-shadow-xl font-oswald bg-[#d3307d] border-r-4 border-[#ae2666]">
                        {{ $live['home_score'] }}
                    </p>
                </div>

                <div class="flex gap-6 justify-between items-center w-full bg-white/90">
                    <p class="text-4xl px-8 py-6 font-extrabold drop-shadow-xl font-oswald bg-[#d3307d] border-l-4 border-[#ae2666]">
                        {{ $live['away_score'] }}
                    </p>
                    <h2 class="px-8 py-6 text-2xl font-bold drop-shadow text-black/80 font-oswald">
                        {{ $live['away_team']['title'] }}
                    </h2>
                    <p class="px-8 py-6 team-logo">
                        <img src="{{ $live['away_team']['logo'] }}" alt="" class="w-12 h-12 rounded-full">
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-10">
                @foreach (range(1, 4) as $quarter)
                    <div class="aspect-square bg-white/90">
                        <h3 class="text-sm bg-[#d3307d] font-oswald text-center text-white/90 px-4 py-2 border-t-4 border-[#ae2666]">Q{{ $quarter }}</h3>
                        <div class="px-6 py-3 text-2xl font-bold text-center font-oswald text-black/80">
                            <span>{{ $live['home_score_p1'] }}</span>
                            <span>:</span>
                            <span>{{ $live['away_score_p1'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="mb-12">
    @endif
</div>
