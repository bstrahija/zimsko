@extends('layouts.app')

@section('content')
    <x-global.header title="Kontakt" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <x-ui.card class="mb-8" title="Vaša donacija" subtitle="Pregled vaše donacije">
                    <livewire:order-overview :order="$order" />
                </x-ui.card>

                @include('products.faq')
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
