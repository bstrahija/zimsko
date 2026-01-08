<x-ui.card class="mb-8" title="Najbolji strijelci">
    @if ($scorers && $scorers->count())
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-2 pb-4 text-left font-medium uppercase tracking-wider text-gray-500">Igrač</th>
                    <th class="px-2 pb-4 text-right font-medium uppercase tracking-wider text-gray-500">P</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($scorers as $position => $item)
                    <x-games.leaders-item :position="$position" :item="$item" :for="'game'" />
                @endforeach
            </tbody>
        </table>
    @else
        <p class="py-4 text-center text-gray-500">Trenutno nema podataka.</p>
    @endif
</x-ui.card>
