@if ($games->count() > 0)
    <div class="upcoming-games mb-12 {{ $class ?? '' }}">
        <x-ui.h2-double sub="Uskoro">Nadolazeće utakmice</x-ui.h2-double>

        <div class="grid bg-white border border-gray-200 rounded-lg shadow {{ $class ?? '' }}">
            @foreach ($games as $game)
                <x-basket.upcoming-games-item :game="$game" />
            @endforeach
        </div>
    </div>
@endif
