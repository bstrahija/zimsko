<div class="grid grid-cols-1 gap-10 mb-8 sm:grid-cols-2">
    @foreach ($products as $index => $product)
        <div class="flex flex-col items-center">
            <h2 class="mb-6 text-2xl font-semibold">{{ $product->title }}</h2>
            <figure class="overflow-hidden mb-6">
                <a href="{{ $product->url }}" class="grid grid-cols-2 gap-4 w-full">
                    <img src="{{ $product->image() }}" alt="{{ $product->title }}" class="object-cover w-full h-64 transition-transform duration-300 hover:scale-110">
                    <img src="{{ $product->imageOther() }}" alt="{{ $product->title }}" class="object-cover w-full h-64 transition-transform duration-300 hover:scale-110">
                </a>
            </figure>
            <div class="grid grid-cols-2 gap-4 w-full">
                <div class="relative">
                    <input type="number" value="0" min="0" wire:model="quantities.{{ $index }}"
                        class="px-4 py-2 w-full text-gray-700 bg-white rounded-md border border-gray-300 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent
                                            {{ $errors->has('quantity.' . $index) ? 'border-red-500' : '' }}">
                    <label class="absolute -top-2 left-2 px-1 text-xs text-gray-500 bg-white">Količina</label>
                    @error('quantity.' . $index)
                        <span class="block mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="relative">
                    <input type="hidden" wire:model="productIds.{{ $index }}">
                    <select name="size" wire:model="sizes.{{ $index }}"
                        class="px-4 py-2 w-full text-gray-700 bg-white rounded-md border border-gray-300 transition duration-150 ease-in-out appearance-none focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="" disabled selected>-- Odaberi --</option>
                        @foreach ($product->variations as $variation)
                            <option value="{{ $variation['slug'] }}">{{ $variation['name'] }}</option>
                        @endforeach
                    </select>
                    <label class="absolute -top-2 left-2 px-1 text-xs text-gray-500 bg-white">Veličina</label>
                    <div class="flex absolute inset-y-0 right-0 items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</div>
