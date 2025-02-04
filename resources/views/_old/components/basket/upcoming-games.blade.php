<x-ui.card class="overflow-x-auto" title="Parovi" subtitle="{{ $currentEvent->title ?: 'Zimsko' }}">
    <div class="game-list">
        @if (!$games->count())
            <p class="py-4 text-center text-gray-500">Trenutno nema dostupnih utakmica.</p>
        @else
            @foreach ($games as $game)
                @if ($game->status === 'in_progress')
                    <livewire:game-item :game="$game" />
                @else
                    <x-basket.game-list-item :game="$game" />
                @endif
            @endforeach
        @endif

        <div class="text-center">
            <x-ui.button tag="a" href="{{ route('schedule') }}">Sve utakmice</x-ui.button>
        </div>
    </div>
</x-ui.card>
