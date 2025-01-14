@php
    use App\Models\Event;
    use App\Services\Leaderboards;

    $hideTitle = $hideTitle ?? false;

    // Check if we have leaderboard data
    if (!isset($leaderboard)) {
        $leaderboard = Leaderboards::getPlayerLeaderboardForEvent(Event::current());
    }
@endphp

<div class="{{ $class ?? '' }}">
    <x-ui.card class="overflow-x-auto" title="Najbolji strijelci" variant="light">
        <table class="w-full text-sm table-auto">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase">Pozicija</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">U</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">P</th>
                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">AVG</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($leaderboard as $position => $item)
                    <x-basket.leaders-item :position="$position" :item="$item" />
                @endforeach
            </tbody>
        </table>
    </x-ui.card>
</div>
