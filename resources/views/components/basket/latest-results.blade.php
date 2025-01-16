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
                <x-basket.game-list-item :game="$game" />
            @endforeach
        @endif

        <div class="text-center">
            <x-ui.button tag="a" href="{{ route('results') }}">Svi rezultati</x-ui.button>
        </div>
    </div>
</x-ui.card>
