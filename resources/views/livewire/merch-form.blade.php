    <div class="mb-8" x-data="{ showDetails: true }">
        <x-ui.card class="mb-8" title="Donacije" subtitle="Ponuda je ograničena">
            @if (isset($products) && count($products) > 0)
                @if (session()->has('message'))
                    <div class="mb-4 rounded-md border-l-4 border-green-500 bg-green-100 p-4 text-green-800 shadow-md">
                        <p class="text-lg font-semibold">{{ session('message') }}</p>
                    </div>
                @else
                    @if (session()->has('error'))
                        <div class="mb-4 rounded-md border-l-4 border-red-500 bg-red-100 p-4 text-red-800 shadow-md">
                            <p class="text-lg font-semibold">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form class="space-y-4" wire:submit.prevent="submit" autocomplete="off">
                        @csrf

                        @include('livewire.merch.heading')

                        @if ($errors->any())
                            {{-- {!! implode('', $errors->all('<div>:message</div>')) !!} --}}
                        @endif

                        @include('livewire.merch.products')

                        <div x-show="showDetails">
                            @include('livewire.merch.form-input')

                            <x-ui.button size="lg" type="submit" variant="primary"
                                class="w-full text-lg font-semibold uppercase tracking-wider transition-colors duration-300 hover:bg-opacity-90">
                                Osiguraj majice
                            </x-ui.button>
                        </div>

                        <x-ui.button size="lg" type="button" variant="primary" x-show="!showDetails"
                            x-on:click="showDetails = true; setTimeout(() => document.getElementById('firstName').focus(), 30);"
                            class="w-full text-lg font-semibold uppercase tracking-wider transition-colors duration-300 hover:bg-opacity-90">
                            Upiši svoje podatke
                        </x-ui.button>

                        {{-- <p>{{ $firstName }}</p>
                        <p>{{ $lastName }}</p>
                        <p>{{ $email }}</p>
                        <p>{{ $teamId }}</p> --}}
                        {{-- <p>
                            @php
                                dump($order);
                                dump($productIds);
                                dump($sizes);
                                dump($quantities);
                            @endphp
                        </p> --}}
                    </form>
                @endif
            @else
                <div class="mb-4 rounded-md border-l-4 border-red-500 bg-red-100 p-4 text-red-800 shadow-md">
                    <p class="text-lg font-semibold">Trenutno nema ponude.</p>
                </div>
            @endif
        </x-ui.card>

        @include('products.faq')
    </div>
