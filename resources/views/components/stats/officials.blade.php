<x-ui.card class="col mb-8" title="Suci" subtitle="Utakmice tokom turnira">
    <div class="w-full overflow-x-auto">
        @if ($officials && $officials->count())
            <table class="w-full text-left text-sm text-gray-700">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="w-[60%] py-3 pl-1 pr-4 font-medium text-gray-500">Sudac</th>

                        <th class="px-4 py-3 text-right font-medium text-gray-500">Utakmica</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($officials as $official)
                        <tr class="transition-colors duration-200 hover:bg-gray-50">
                            <td class="py-3 pl-0 pr-4 text-xs font-semibold text-gray-800">
                                {{ $official->first_name }} {{ $official->last_name }}
                            </td>
                            <td class="py-3 pl-0 pr-4 text-right text-xs font-semibold text-gray-800">
                                {{ $official->games_officiated }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="p-4 text-sm text-gray-600">Nema dostupnih podataka o sucima.</p>
        @endif
    </div>
</x-ui.card>
