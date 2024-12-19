<div class="mb-12 latest-results">
    <x-ui.h2-double sub="Rezultati">Posljednje utakmice</x-ui.h2-double>

    <div class="grid grid-cols-5 gap-8">
        @foreach ($latestGames as $game)
            <x-basket.latest-results-item :game="$game" />
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <x-ui.button tag="a" variant="secondary" size="lg" href="{{ route('results') }}">Pogledaj sve rezultate</x-ui.button>
    </div>
</div>
