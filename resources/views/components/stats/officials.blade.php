<x-ui.card class="mb-8 col" title="Suci" subtitle="Utakmice tokom turnira">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="pr-4 pl-1 py-3 font-medium text-gray-500 w-[60%]">Sudac</th>

                    <th class="px-4 py-3 font-medium text-right text-gray-500">Utakmica</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($officials as $official)
                    <tr class="transition-colors duration-200 hover:bg-gray-50">
                        <td class="py-3 pr-4 pl-0 text-xs font-semibold text-gray-800">
                            {{ $official->first_name }} {{ $official->last_name }}
                        </td>
                        <td class="py-3 pr-4 pl-0 text-xs font-semibold text-right text-gray-800">
                            {{ $official->games_officiated }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-ui.card>
