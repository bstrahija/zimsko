@extends('layouts.app')

@section('content')
    @if ($team->photo())
        <x-global.header-photo title="{{ $team->title }}" subtitle="Sve utakmice" url="{{ $team->photo('original') }}" />
    @else
        <x-global.header title="{{ $team->title }}" subtitle="Sve utakmice" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <livewire:team.games-list :team="$team" />
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8" title="{{ $team->title }}" icon="{{ $team->logo('original') }}">
                    <x-teams.details :team="$team" />
                </x-ui.card>

                <x-ui.card class="mb-8">
                    <a href="{{ route('teams.show', $team->slug) }}" class="flex items-center text-primary hover:underline">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Nazad na stranicu ekipe
                    </a>
                </x-ui.card>
            </x-global.sidebar>
        </div>
    </div>
@endsection
