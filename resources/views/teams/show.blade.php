@extends('layouts.app')

@section('content')
    @if ($team->photo())
        <x-header-photo title="{{ $team->title }}" url="{{ $team->photo('original') }}" />
    @else
        <x-header title="{{ $team->title }}" />
    @endif

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-4">
                    <x-ui.card class="flex flex-col gap-4 items-center">
                        <div class="max-w-[160px] max-h-[160px] text-center">
                            <img src="{{ $team->logo('original') }}" alt="{{ $team->title }}" class="object-contain w-full h-auto">
                        </div>
                    </x-ui.card>

                    <x-ui.card class="overflow-x-auto">
                        <table class="w-full text-sm table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-2 pb-4 font-medium tracking-wider text-left text-gray-500 uppercase"></th>
                                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Broj</th>
                                    <th class="px-2 pb-4 font-medium tracking-wider text-right text-gray-500 uppercase">Pozicija</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($team->players as $player)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-2 py-3">
                                            <div class="flex items-center">
                                                <img src="{{ $player->photo() ?: $team->logo() }}" alt="{{ $player->name }}" class="mr-3 w-8 h-8 rounded-full">
                                                <span class="font-medium text-gray-900">{{ $player->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-2 py-3 text-right text-gray-500">{{ $player->number }}</td>
                                        <td class="px-2 py-3 text-right text-gray-500">{{ $player->position }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </x-ui.card>
                </div>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4">
                <x-ui.card class="mb-8">
                    <a href="{{ $team->photo('original') }}" target="_blank"><img src="{{ $team->photo('original') }}" alt="{{ $team->title }}" class="w-full"></a>
                </x-ui.card>
            </x-sidebar>
        </div>
    </div>
@endsection
