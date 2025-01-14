<div class="mb-12 latest-results" data-animate="@sm:from:opacity-0">
    <x-ui.h2-double sub="Rezultati">Posljednje utakmice</x-ui.h2-double>

    <div class="grid grid-cols-1 gap-4 lg:gap-6 xl-+:gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 3xl:grid-cols-6">
        @foreach ($latestGames as $index => $game)
            <x-basket.latest-results-item :game="$game" class="" />
        @endforeach
    </div>

    <div class="flex justify-center mt-8">
        <x-ui.button tag="a" variant="secondary" size="lg" href="{{ route('results') }}">Pogledaj sve rezultate</x-ui.button>
    </div>
</div>
