<x-ui.card class="text-center {{ $class ?? '' }} item">
    <a href="#" class="block">
        <div class="p-2 -mx-6 -mt-6 mb-4 text-sm text-white bg-gradient-to-br rounded-t from-secondary/95 to-secondary/70">
            {{ $game->scheduled_at->format('d.m.Y') }}
            <!-- <small>{{ $game->scheduled_at->format('H:i') }}</small> -->
        </div>

        <div class="mb-3 text-xs font-bold text-gray-500 uppercase">
            {{ $game->round?->title }}
        </div>

        <div class="flex justify-between items-center mb-6">
            <div class="flex-1 team">
                <figure class="flex overflow-hidden justify-center items-center mx-auto mb-2 w-12 h-12 bg-gray-100 rounded-full">
                    <!-- <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg> -->
                    <img src="{{ $game->homeTeam->logo() }}" alt="{{ $game->homeTeam->short_title }}" class="w-12 h-12">
                </figure>
                <h3 class="font-bold">{{ $game->homeTeam->short_title }}</h3>
                <p class="mt-1 text-3xl font-bold {{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->home_score }}</p>
            </div>

            <div class="mx-4 font-bold text-gray-400">VS</div>

            <div class="flex-1 team">
                <figure class="flex overflow-hidden justify-center items-center mx-auto mb-2 w-12 h-12 bg-white rounded-full">
                    {{-- <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg> --}}
                    <img src="{{ $game->awayTeam->logo() }}" alt="{{ $game->awayTeam->short_title }}" class="w-12 h-12">
                </figure>
                <h3 class="font-bold">{{ $game->awayTeam->short_title }}</h3>
                <p class="mt-1 text-3xl font-bold {{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-400' }}">{{ $game->away_score }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 pt-4 text-sm text-gray-600 border-t">
            <div class="period">
                <div class="font-bold">Q1</div>
                {{ $game->home_score_p1 }}:{{ $game->away_score_p1 }}
            </div>
            <div class="period">
                <div class="font-bold">Q2</div>
                {{ $game->home_score_p2 }}:{{ $game->away_score_p2 }}
            </div>
            <div class="period">
                <div class="font-bold">Q3</div>
                {{ $game->home_score_p3 }}:{{ $game->away_score_p3 }}
            </div>
            <div class="period">
                <div class="font-bold">Q4</div>
                {{ $game->home_score_p4 }}:{{ $game->away_score_p4 }}
            </div>
        </div>
    </a>
</x-ui.card>
