<div>
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_260px] mb-8">
        <h1 class="mb-4 text-2xl font-bold text-left font-condensed text-secondary md:text-3xl">
            Rezultati utakmica
        </h1>

        <div class="inline-block relative text-right">
            <select wire:model="selectedEventSlug" wire:change="reloadResults"
                class="block px-4 py-2 pr-8 w-full leading-tight text-gray-700 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option disabled>Odaberi turnir</option>
                @foreach ($events as $event)
                    <option value="{{ $event->slug }}" wire:key="event-{{ $event->slug }}">{{ $event->title }}</option>
                @endforeach
            </select>
            <div class="flex absolute right-0 top-3 items-center px-2 pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <div class="grid gap-4">
        @if (!$results || !count($results))
            <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
                Nisu pronađene utakmice
            </div>
        @else
            @foreach ($results as $game)
                <x-ui.card>
                    <div x-data="{ open: false }">
                        <div>
                            <a href="{{ route('games.show', $game->slug) }}" class="block mb-2 text-sm text-gray-500 transition-all hover:text-primary">
                                <h2 class="mb-1 font-bold text-center">{{ $game->title }}</h2>
                                <small class="block text-center">{{ $game->scheduled_at->format('d.m.Y. H:i') }}</small>
                            </a>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="flex flex-col gap-3 items-center md:gap-6 md:flex-row">
                                <a href="{{ route('teams.show', $game->homeTeam->slug) }}" class="mb-2">
                                    <img src="{{ $game->homeTeam->logo() }}" class="object-contain rounded-full shadow-md size-10 md:size-16 sm:w-20 sm:h-20"
                                        alt="{{ $game->homeTeam->title }}">
                                </a>
                                <a href="{{ route('games.show', $game->homeTeam->slug) }}"
                                    class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->homeTeam->title }}</a>
                            </div>

                            <div class="pt-3 text-center">
                                <a href="{{ route('games.show', $game->slug) }}" class="block mb-6 text-lg font-bold md:mb-2 md:text-3xl sm:text-4xl">
                                    <span class="{{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    <span class="text-gray-400 md:mx-2">:</span>
                                    <span class="{{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                </a>

                                <button @click="open = !open"
                                    class="px-3 py-1 text-xs font-medium text-gray-500 bg-gray-50 rounded transition-colors hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-200">
                                    <span x-show="!open">Detalji</span>
                                    <span x-show="open">Sakrij</span>
                                </button>
                            </div>

                            <div class="flex flex-col gap-3 items-center md:gap-6 md:flex-row-reverse">
                                <a href="{{ route('teams.show', $game->awayTeam->slug) }}" class="mb-2">
                                    <img src="{{ $game->awayTeam->logo() }}" class="object-contain rounded-full shadow-md size-10 md:size-16 sm:w-20 sm:h-20"
                                        alt="{{ $game->awayTeam->title }}">
                                </a>
                                <a href="{{ route('teams.show', $game->awayTeam->slug) }}"
                                    class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->awayTeam->title }}</a>
                            </div>
                        </div>

                        <div x-show="open" class="mt-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                            <div class="grid grid-cols-2 gap-2 text-sm text-center sm:grid-cols-4 sm:gap-4">
                                <div class="p-2 bg-gray-100 rounded-md">
                                    <div class="font-semibold">Q1</div>
                                    <div>
                                        <span class="{{ $game->home_score_p1 > $game->away_score_p1 ? 'text-green-600 font-semibold' : '' }}">{{ $game->home_score_p1 }} </span>
                                        -
                                        <span class="{{ $game->away_score_p1 > $game->home_score_p1 ? 'text-green-600 font-semibold' : '' }}">{{ $game->away_score_p1 }}</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-md">
                                    <div class="font-semibold">Q2</div>
                                    <div>
                                        <span class="{{ $game->home_score_p2 > $game->away_score_p2 ? 'text-green-600 font-semibold' : '' }}">{{ $game->home_score_p2 }} </span>
                                        -
                                        <span class="{{ $game->away_score_p2 > $game->home_score_p2 ? 'text-green-600 font-semibold' : '' }}">{{ $game->away_score_p2 }}</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-md">
                                    <div class="font-semibold">Q3</div>
                                    <div>
                                        <span class="{{ $game->home_score_p3 > $game->away_score_p3 ? 'text-green-600 font-semibold' : '' }}">{{ $game->home_score_p3 }} </span>
                                        -
                                        <span class="{{ $game->away_score_p3 > $game->home_score_p3 ? 'text-green-600 font-semibold' : '' }}">{{ $game->away_score_p3 }}</span>
                                    </div>
                                </div>
                                <div class="p-2 bg-gray-100 rounded-md">
                                    <div class="font-semibold">Q4</div>
                                    <div>
                                        <span class="{{ $game->home_score_p4 > $game->away_score_p4 ? 'text-green-600 font-semibold' : '' }}">{{ $game->home_score_p4 }} </span>
                                        -
                                        <span class="{{ $game->away_score_p4 > $game->home_score_p4 ? 'text-green-600 font-semibold' : '' }}">{{ $game->away_score_p4 }}</span>
                                    </div>
                                </div>

                                <!-- Also check for overtime -->
                                @if ($game->home_score_p5 || $game->away_score_p5)
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">OT</div>
                                        <div>
                                            <span class="{{ $game->home_score_p5 > $game->away_score_p5 ? 'text-green-600 font-semibold' : '' }}">{{ $game->home_score_p5 }}
                                            </span>
                                            -
                                            <span
                                                class="{{ $game->away_score_p5 > $game->home_score_p5 ? 'text-green-600 font-semibold' : '' }}">{{ $game->away_score_p5 }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach




            {{-- @foreach ($results as $game)
                <x-ui.card>
                    <div class="flex flex-col pt-2" x-data="{ open: false }">
                        <div class="flex flex-col items-center mb-4 sm:flex-row sm:justify-between">
                            <div class="flex flex-col items-center mb-4 sm:w-1/4 sm:mb-0">
                                <a href="{{ route('teams.show', $game->homeTeam->slug) }}" class="mb-2">
                                    <img src="{{ $game->homeTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20"
                                        alt="{{ $game->homeTeam->title }}">
                                </a>
                                <a href="{{ route('teams.show', $game->homeTeam->slug) }}"
                                    class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->homeTeam->title }}</a>
                            </div>

                            <div class="flex flex-col items-center mb-4 sm:order-first sm:w-2/4 sm:mb-0">
                                <a href="{{ route('games.show', $game->slug) }}" class="block mb-2 text-sm text-gray-500">
                                    <h2 class="mb-1 font-bold text-center">{{ $game->title }}</h2>
                                    <small class="block text-center">{{ $game->scheduled_at->format('d.m.Y. H:i') }}</small>
                                </a>
                                <a href="{{ route('games.show', $game->slug) }}" class="block mb-2 text-3xl font-bold sm:text-4xl">
                                    <span class="{{ $game->home_score > $game->away_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->home_score }}</span>
                                    <span class="mx-2 text-gray-400">-</span>
                                    <span class="{{ $game->away_score > $game->home_score ? 'text-primary' : 'text-gray-500' }}">{{ $game->away_score }}</span>
                                </a>

                                <button @click="open = !open"
                                    class="px-3 py-1 text-xs font-medium text-gray-500 bg-gray-50 rounded transition-colors hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-gray-200">
                                    <span x-show="!open">Detalji</span>
                                    <span x-show="open">Sakrij</span>
                                </button>
                            </div>

                            <div class="flex flex-col items-center sm:w-1/4">
                                <a href="{{ route('teams.show', $game->awayTeam->slug) }}" class="mb-2">
                                    <img src="{{ $game->awayTeam->logo() }}" class="object-contain w-16 h-16 rounded-full shadow-md sm:w-20 sm:h-20"
                                        alt="{{ $game->awayTeam->title }}">
                                </a>
                                <a href="{{ route('teams.show', $game->awayTeam->slug) }}"
                                    class="text-base font-bold text-center text-gray-700 transition hover:text-primary sm:text-lg">{{ $game->awayTeam->title }}</a>
                            </div>
                        </div>

                        <div class="w-full">
                            <div x-show="open" class="mt-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                                <div class="grid grid-cols-2 gap-2 text-sm text-center sm:grid-cols-4 sm:gap-4">
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q1</div>
                                        <div>{{ $game->home_score_p1 }} - {{ $game->away_score_p1 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q2</div>
                                        <div>{{ $game->home_score_p2 }} - {{ $game->away_score_p2 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q3</div>
                                        <div>{{ $game->home_score_p3 }} - {{ $game->away_score_p3 }}</div>
                                    </div>
                                    <div class="p-2 bg-gray-100 rounded-md">
                                        <div class="font-semibold">Q4</div>
                                        <div>{{ $game->home_score_p4 }} - {{ $game->away_score_p4 }}</div>
                                    </div>

                                    <!-- Also check for overtime -->
                                    @if ($game->home_score_p5 || $game->away_score_p5)
                                        <div class="p-2 bg-gray-100 rounded-md">
                                            <div class="font-semibold">OT</div>
                                            <div>{{ $game->home_score_p5 }} - {{ $game->away_score_p5 }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach --}}

            <div class="mt-6">
                {{ $results->links() }}
            </div>
        @endif
    </div>
</div>
