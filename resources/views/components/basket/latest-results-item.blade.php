<x-ui.card class="text-center {{ $class ?? '' }}">
    <a href="#" class="block">
        <div
            class="text-sm mb-4 bg-gradient-to-br from-secondary/95 to-secondary/70 text-white p-2 -mt-6 -mx-6 rounded-t-lg">
            {{ $game->scheduled_at->format('d.m.Y') }}

        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="team flex-1">
                <figure
                    class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                    <!-- <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg> -->
                    <img src="{{ $game->homeTeam->logo() }}" alt="{{ $game->homeTeam->short_title }}" class="w-12 h-12">
                </figure>
                <h3 class="font-bold">{{ $game->homeTeam->short_title }}</h3>
                <p class="text-3xl font-bold text-primary mt-1">{{ $game->home_score }}</p>
            </div>

            <div class="mx-4 text-gray-400 font-bold">VS</div>

            <div class="team flex-1">
                <figure
                    class="w-12 h-12 mx-auto mb-2 bg-white rounded-full flex items-center justify-center overflow-hidden">
                    {{-- <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg> --}}
                    <img src="{{ $game->awayTeam->logo() }}" alt="{{ $game->awayTeam->short_title }}" class="w-12 h-12">
                </figure>
                <h3 class="font-bold">{{ $game->awayTeam->short_title }}</h3>
                <p class="text-3xl font-bold text-primary mt-1">{{ $game->away_score }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 text-sm text-gray-600 border-t pt-4">
            <div class="quarter">
                <div class="font-bold">Q1</div>
                {{ $game->home_score_q1 }}:{{ $game->away_score_q1 }}
            </div>
            <div class="quarter">
                <div class="font-bold">Q2</div>
                {{ $game->home_score_q2 }}:{{ $game->away_score_q2 }}
            </div>
            <div class="quarter">
                <div class="font-bold">Q3</div>
                {{ $game->home_score_q3 }}:{{ $game->away_score_q3 }}
            </div>
            <div class="quarter">
                <div class="font-bold">Q4</div>
                {{ $game->home_score_q4 }}:{{ $game->away_score_q4 }}
            </div>
        </div>
    </a>
</x-ui.card>
