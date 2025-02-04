@extends('layouts.app')

@section('content')
    <x-header title="Rezultati" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                @if ($game->status === 'in_progress')
                    <livewire:live-game :game="$game" />
                @else
                    <x-games.score :game="$game" />

                    <x-games.stats :game="$game" :live="$live" />

                    <x-games.log-stream :game="$game" :log="$log" />

                    <x-ui.card class="mb-8" title="Najbolji strijelci">
                        @if ($scorers && $scorers->count())
                            <table class="w-full text-sm table-auto">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase">Igrač</th>
                                        <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">P</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($scorers as $position => $item)
                                        <x-basket.leaders-item :position="$position" :item="$item" :for="'game'" />
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="py-4 text-center text-gray-500">Trenutno nema podataka.</p>
                        @endif
                    </x-ui.card>
                @endif
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
