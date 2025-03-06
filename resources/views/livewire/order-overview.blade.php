<div>
    @if ($confirmed || $order->status === 'confirmed')
        <div class="p-6 mb-6 text-center bg-green-50 rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <h2 class="mb-2 text-2xl font-bold text-green-700">Hvala na vašoj donaciji!</h2>
            <p class="mb-4 text-gray-700">Vaša podrška nam puno znači i pomaže nam u organizaciji turnira.</p>
        </div>
    @else
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

        <x-ui.button size="lg" variant="primary" wire:click="confirm"
            class="mt-6 w-full text-lg font-semibold tracking-wider uppercase transition-colors duration-300 hover:bg-opacity-90">
            Potvrdi donaciju
        </x-ui.button>
    @endif
</div>
