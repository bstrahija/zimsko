@php
    if ($games && $games->first()) {
        $title = $games->first()->event->title;
    } else {
        $title = $currentEvent->title ?: 'Zimsko';
    }
@endphp

<x-ui.card class="overflow-x-auto" title="Rezultati" subtitle="{{ $title }}">
    <div class="game-list">
        @if (!$games->count())
            <p class="py-4 text-center text-gray-500">Trenutno nema rezultata.</p>
        @else
            @foreach ($games as $game)
                <div
                    class="pt-2 pb-4 mb-4 rounded-lg border-b border-gray-200 transition-all duration-300 transform hover:from-gray-200 hover:to-gray-100 hover:scale-105 hover:shadow-lg">
                    <div class="mb-2 text-sm text-center uppercase font-roboto text-secondary">
                        <span class="font-bold">{{ $game->round->title }}</span>
                        <small>({{ $game->scheduled_at->format('d.m.Y H:i') }})</small>
                    </div>

                    <a href="{{ route('results.show', $game->slug) }}" class="game-list__item grid grid-cols-[10%_22%_auto_22%_10%] gap-6 font-condensed ">
                        <div class="flex justify-center items-center"><img src="{{ $game->homeTeam->logo() }}" alt=""
                                class="max-h-12 rounded-full transition-transform duration-300 transform max-w-12 hover:scale-110"></div>

                        <div class="flex items-center transition-colors duration-300 hover:text-primary">
                            <span class="overflow-hidden max-w-full whitespace-nowrap text-ellipsis">{{ $game->homeTeam->title }}</span>
                        </div>

                        <div class="flex items-center text-xl font-bold font-condensed text-primary">
                            <span class="{{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->home_score }}</span>
                            <span class="mx-1">:</span>
                            <span class="{{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->away_score }}</span>
                        </div>

                        <div class="flex justify-end items-center transition-colors duration-300 hover:text-primary">
                            <span class="overflow-hidden max-w-full whitespace-nowrap text-ellipsis">{{ $game->awayTeam->title }}</span>
                        </div>

                        <div class="flex justify-center items-center"><img src="{{ $game->awayTeam->logo() }}" alt=""
                                class="max-h-12 rounded-full transition-transform duration-300 transform max-w-12 hover:scale-110"></div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</x-ui.card>
