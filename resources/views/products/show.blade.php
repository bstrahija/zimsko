@extends('layouts.app')

@section('content')
    <x-global.header title="Kontakt" />

    <div class="wrapper">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-12">
            <div class="md:col-span-12 lg:col-span-8">
                <x-ui.card class="mb-8" title="Vaša donacija" subtitle="Pregled vaše donacije">
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                            <dt class="text-sm font-medium text-gray-500">Ime:</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $order->name }}</dd>
                        </div>
                        <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                            <dt class="text-sm font-medium text-gray-500">Podržana ekipa:</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $order?->team?->title ?: '-' }}</dd>
                        </div>
                        <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                            <dt class="text-sm font-medium text-gray-500">Email:</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $order->email }}</dd>
                        </div>
                        @foreach ($order->orderItems as $orderItem)
                            <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                                <dt class="text-sm font-medium text-gray-500">{{ $orderItem->product->title }} ({{ strtoupper($orderItem->variation) }})</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $orderItem->quantity }} kom</dd>
                            </div>
                        @endforeach
                    </dl>
                </x-ui.card>

                @include('products.faq')
            </div>

            <x-global.sidebar class="md:col-span-12 lg:col-span-4" />
        </div>
    </div>
@endsection
