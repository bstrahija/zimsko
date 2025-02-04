@extends('layouts.app')

@section('content')
    <x-header title="Globetka utakmice" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <div class="grid gap-4">
                    @if (!$games || !count($games))
                        <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
                            Nisu pronađene utakmice
                        </div>
                    @else
                        @foreach ($games as $game)
                            <x-ui.card>
                                <x-basket.game-list-item :game="$game" />
                            </x-ui.card>
                        @endforeach
                    @endif
                </div>

                <div class="mt-6">
                    {{ $games->links() }}
                </div>
            </div>

            <x-sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
