<div class="pb-4 mb-6 border-b">
    <div class="mb-4 text-sm text-center uppercase font-roboto text-secondary">
        <span class="font-bold">
            @if ($game->round->type === 'finals')
                🏆
            @elseif ($game->round->type === 'placing' && $game->round->subtype === '3rd')
                🥉
            @endif

            {{ $game->round->title }}
        </span>
        <small>({{ $game->scheduled_at->format('d.m.Y H:i') }})</small>
    </div>

    <a href="{{ route('results.show', $game->slug) }}"
        class="game-list__item grid grid-cols-[33%_auto_33%] max-w-full overflow-hidden md:grid-cols-[10%_28%_auto_28%_10%] gap-3 font-condensed hover:scale-105 transition-all">
        <div class="flex flex-col gap-4 items-center text-center">
            <div class="flex justify-center items-center"><img src="{{ $game->homeTeam->logo() }}" alt=""
                    class="max-h-8 rounded-full transition-transform duration-300 transform max-w-8 md:max-h-12 md:max-w-12 hover:scale-110"></div>

            <div class="flex items-center transition-colors duration-300 hover:text-primary">
                <span class="overflow-hidden max-w-full">{{ $game->homeTeam->title }}</span>
            </div>
        </div>

        <div class="flex justify-center items-center text-lg font-bold md:text-xl font-condensed text-primary">
            <span class="{{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->home_score }}</span>
            <span class="mx-1">:</span>
            <span class="{{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->away_score }}</span>
        </div>

        <div class="flex flex-col gap-4 justify-center items-center text-center">
            <div class="flex justify-center items-center"><img src="{{ $game->awayTeam->logo() }}" alt=""
                    class="max-h-8 rounded-full transition-transform duration-300 transform max-w-8 md:max-h-12 md:max-w-12 hover:scale-110"></div>

            <div class="flex justify-end items-center transition-colors duration-300 hover:text-primary">
                <span class="block overflow-hidden max-w-full">{{ $game->awayTeam->title }}</span>
            </div>
        </div>
    </a>
</div>
