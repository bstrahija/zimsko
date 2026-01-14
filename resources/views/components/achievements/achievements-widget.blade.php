@props(['class' => '', 'title' => 'Dostignuća', 'subtitle' => 'Najbolji trenuci', 'team' => null, 'player' => null])

@php
    use App\Models\Achievement;

    // Fetch achievements from database based on team or player
    $achievementsQuery = Achievement::with('event')->where('is_active', true);

    if ($team) {
        $achievementsQuery->where('team_id', $team->id)->whereNull('player_id');
    } elseif ($player) {
        $achievementsQuery->where('player_id', $player->id);
    } else {
        $achievementsQuery->whereRaw('1 = 0'); // No results if no team or player
    }

    $dbAchievements = $achievementsQuery->orderByDesc('created_at')->get();

    // Map database achievements to display format using config
    $achievements = $dbAchievements
        ->map(function ($achievement) {
            $config = config('achievements.' . $achievement->type, [
                'title' => $achievement->type,
                'description' => '',
                'image' => 'achievements/trophy-gold.png',
            ]);

            return [
                'title' => $config['title'],
                'subtitle' => $achievement->event?->title ?? ($achievement->description ?? ''),
                'image' => '/' . $config['image'],
            ];
        })
        ->toArray();
@endphp

@if (count($achievements) > 0)
    <div class="{{ $class }}">
        <x-ui.card class="overflow-hidden" :title="$title" :subtitle="$subtitle" variant="light">
            <div
                x-data="{
                    currentSlide: 0,
                    totalSlides: {{ count($achievements) }},
                    autoplayInterval: null,
                    init() {
                        this.startAutoplay();
                    },
                    next() {
                        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                    },
                    prev() {
                        this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                    },
                    goTo(index) {
                        this.currentSlide = index;
                    },
                    startAutoplay() {
                        this.autoplayInterval = setInterval(() => {
                            this.next();
                        }, 4000);
                    },
                    stopAutoplay() {
                        clearInterval(this.autoplayInterval);
                    },
                }"
                @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()"
                class="relative">
                {{-- Carousel Container --}}
                <div class="relative overflow-hidden">
                    <div
                        class="flex transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${currentSlide * 100}%)`">
                        @foreach ($achievements as $index => $achievement)
                            <div class="w-full flex-shrink-0">
                                <div class="flex flex-col items-center px-4 py-6 text-center">
                                    {{-- Trophy Image --}}
                                    <div class="relative mb-4">
                                        <div
                                            class="absolute inset-0 rounded-full bg-gradient-to-b from-primary/20 to-transparent blur-xl">
                                        </div>
                                        <img
                                            src="{{ $achievement['image'] }}"
                                            alt="{{ $achievement['title'] }}"
                                            class="relative z-10 h-24 w-24 object-contain drop-shadow-lg transition-transform duration-300 hover:scale-110">
                                    </div>

                                    {{-- Achievement Info --}}
                                    <h3 class="mb-1 font-heading text-xl font-bold text-secondary">
                                        {{ $achievement['title'] }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $achievement['subtitle'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Navigation Arrows --}}
                <button
                    @click="prev()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 p-2 text-secondary transition-colors duration-200 hover:text-primary focus:outline-none"
                    aria-label="Prethodno dostignuće">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button
                    @click="next()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 p-2 text-secondary transition-colors duration-200 hover:text-primary focus:outline-none"
                    aria-label="Sljedeće dostignuće">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Dot Indicators --}}
                <div class="mt-4 flex justify-center gap-2">
                    @foreach ($achievements as $index => $achievement)
                        <button
                            @click="goTo({{ $index }})"
                            :class="currentSlide === {{ $index }} ? 'bg-primary' : 'bg-gray-300 hover:bg-gray-400'"
                            class="h-2 w-2 rounded-full transition-colors duration-200 focus:outline-none"
                            aria-label="Idi na dostignuće {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </x-ui.card>
    </div>
@endif
