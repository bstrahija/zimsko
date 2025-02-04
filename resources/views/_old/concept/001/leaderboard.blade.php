<div class="relative z-10 border rounded-lg overflow-hidden bg-center
    bg-cover bg-no-repeat bg-[#0F101A] border-[#939DB8]/10  hover:scale-[1.01] transition px-6 py-8">
    <h3 class="mb-6 text-xl font-bold glow-hover">Team Rankings</h3>
    <div class="text-sm">
        <!-- Teams -->
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-300 uppercase">
                <tr>
                    <th scope="col" class="py-3 pr-4 text-left">Team</th>
                    <th scope="col" class="px-4 py-3 text-center">U</th>
                    <th scope="col" class="px-4 py-3 text-center">P</th>
                    <th scope="col" class="px-4 py-3 text-center">I</th>
                    <th scope="col" class="px-4 py-3 text-center">K</th>
                    <th scope="col" class="py-3 pl-4 text-right">B</th>
                </tr>
            </thead>
            <tbody class="text-xs text-neutral">
                @foreach (range(1, 10) as $position)
                    <tr class="border-t border-gray-600">
                        <td class="py-4 pr-4">1. Warriors</td>
                        <td class="px-4 py-4 text-center">16</td>
                        <td class="px-4 py-4 text-center">14</td>
                        <td class="px-4 py-4 text-center">2</td>
                        <td class="px-4 py-4 text-center">1245</td>
                        <td class="py-4 pl-4 font-semibold text-right">30</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
