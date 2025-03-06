@php
    use App\Models\Product;
@endphp

<div class="{{ $class ?? '' }}">
    <x-ui.card class="overflow-x-auto space-y-4" title="Donacije" subtitle="Ponuda je ograničena" variant="light">
        @foreach (Product::with('media')->get() as $index => $product)
            <div class="flex flex-col items-center">
                <h2 class="mb-6 text-2xl font-semibold">{{ $product->title }}</h2>
                <figure class="overflow-hidden mb-6">
                    <a href="{{ route('products.index') }}" class="grid grid-cols-2 gap-4 w-full">
                        <img src="{{ $product->image() }}" alt="{{ $product->title }}" class="object-cover w-full h-64 transition-transform duration-300 hover:scale-110">
                        <img src="{{ $product->imageOther() }}" alt="{{ $product->title }}" class="object-cover w-full h-64 transition-transform duration-300 hover:scale-110">
                    </a>
                </figure>
            </div>
        @endforeach

        <x-ui.button size="lg" tag="a" variant="primary" href="{{ route('products.index') }}"
            class="mt-4 w-full text-lg font-semibold tracking-wider uppercase transition-colors duration-300 hover:bg-opacity-90">
            Osiguraj majice
        </x-ui.button>
    </x-ui.card>
</div>
