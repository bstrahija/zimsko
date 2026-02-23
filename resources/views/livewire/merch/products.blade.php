<div class="mb-8 grid grid-cols-1 gap-10 sm:grid-cols-2">
    @foreach ($products as $index => $product)
        <div class="flex flex-col items-center">
            <h2 class="mb-6 text-2xl font-semibold">{{ $product->title }}</h2>
            <figure class="mb-6 overflow-hidden">
                <span
                    class="@if ($product->imageOther()) grid-cols-2 @else grid-cols-1 @endif grid w-full items-center gap-4">
                    <a href="{{ $product->image('') }}" target="_blank" class="lightbox" data-pswp-width="1000"
                        data-pswp-height="1150">
                        <img src="{{ $product->image() }}" alt="{{ $product->title }}"
                            class="h-64 w-full object-cover transition-transform duration-300 hover:scale-110">
                    </a>

                    @if ($product->imageOther())
                        <a href="{{ $product->imageOther('') }}" target="_blank" class="lightbox" data-pswp-width="1000"
                            data-pswp-height="1100">
                            <img src="{{ $product->imageOther() }}" alt="{{ $product->title }}"
                                class="h-64 w-full object-cover transition-transform duration-300 hover:scale-110">
                        </a>
                    @endif
                </span>
            </figure>
            <div class="grid w-full grid-cols-2 gap-4">
                <div class="relative">
                    <input type="number" value="0" min="0" wire:model="quantities.{{ $index }}"
                        class="{{ $errors->has('quantity.' . $index) ? 'border-red-500' : '' }} w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-700 transition duration-150 ease-in-out focus:border-transparent focus:outline-none focus:ring-2 focus:ring-primary">
                    <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-gray-500">Količina</label>
                    @error('quantity.' . $index)
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="relative">
                    <input type="hidden" wire:model="productIds.{{ $index }}">
                    <select name="size" wire:model="sizes.{{ $index }}"
                        class="w-full appearance-none rounded-md border border-gray-300 bg-white px-4 py-2 text-gray-700 transition duration-150 ease-in-out focus:border-transparent focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="" disabled selected>-- Odaberi --</option>
                        @foreach ($product->variations as $variation)
                            <option value="{{ $variation['slug'] }}">{{ $variation['name'] }}</option>
                        @endforeach
                    </select>
                    <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-gray-500">Veličina</label>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
