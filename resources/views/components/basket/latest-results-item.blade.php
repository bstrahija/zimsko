<x-ui.card class="text-center {{ $class ?? '' }}">
    <div class="text-sm text-gray-500 mb-4">05-01-2020 20:00</div>

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
        <div class="quarter">21:18</div>
        <div class="quarter">17:13</div>
        <div class="quarter">12:19</div>
        <div class="quarter">31:8</div>
    </div>
</x-ui.card>
