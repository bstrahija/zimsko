@extends('layouts.app')

@section('content')
    <x-global.header title="Ekipe" />

    <div class="mt-12 wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($teams as $team)
                        <div class="flex flex-col items-center">
                            <x-ui.card class="flex flex-col items-center p-6 w-full transition duration-300 ease-in-out transform hover:shadow-lg hover:-translate-y-1">
                                <a href="{{ route('teams.show', $team->slug) }}" class="overflow-hidden mb-4 rounded-full">
                                    <img src="{{ $team->logo() }}" alt="{{ $team->title }}"
                                        class="object-contain w-32 h-32 transition duration-300 ease-in-out transform hover:scale-110" />
                                </a>
                                <h3 class="text-lg font-semibold text-center">
                                    <a href="{{ route('teams.show', $team->slug) }}" class="transition duration-300 ease-in-out hover:text-primary">
                                        {{ $team->title }}
                                    </a>
                                </h3>
                            </x-ui.card>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
