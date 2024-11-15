<x-ui.card class="text-center {{ $class ?? '' }}">
    <a href="#" class="block">
        <div
            class="text-sm mb-4 bg-gradient-to-br from-secondary/95 to-secondary/70 text-white p-2 -mt-6 -mx-6 rounded-t-lg">
            ned. 21.02.2024. 08:00
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="team flex-1">
                <figure class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg>
                </figure>
                <h3 class="font-bold">KK ČKV</h3>
                <p class="text-3xl font-bold text-primary mt-1">95</p>
            </div>

            <div class="mx-4 text-gray-400 font-bold">VS</div>

            <div class="team flex-1">
                <figure class="w-12 h-12 mx-auto mb-2 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    </svg>
                </figure>
                <h3 class="font-bold">KK ZGB</h3>
                <p class="text-3xl font-bold text-primary mt-1">83</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-2 text-sm text-gray-600 border-t pt-4">
            <div class="quarter">
                <div class="font-bold">Q1</div>
                21:18
            </div>
            <div class="quarter">
                <div class="font-bold">Q2</div>
                17:13
            </div>
            <div class="quarter">
                <div class="font-bold">Q3</div>
                12:19
            </div>
            <div class="quarter">
                <div class="font-bold">Q4</div>
                31:8
            </div>
        </div>
    </a>
</x-ui.card>
