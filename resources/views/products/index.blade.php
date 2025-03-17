@extends('layouts.app')

@section('content')
    <x-global.header title="Kontakt" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                {{-- <livewire:merch-form :products="$products" /> --}}

                <x-ui.card class="overflow-x-auto space-y-4" title="Donacije" subtitle="Ponuda je ograničena" variant="light">
                    <div class="p-4 bg-yellow-50 rounded-md border-l-4 border-yellow-400">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Obavijest</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Donacije su trenutno zatvorene. Hvala na razumijevanju!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
