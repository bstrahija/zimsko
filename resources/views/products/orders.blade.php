<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="">
        <div class="mx-auto text-xs wrapper">
            <div class="overflow-hidden bg-white rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase print:hidden">ID</th>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">Ime/Email</th>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">Količina</th>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">Datum</th>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">Ekipa</th>
                            <th class="px-3 py-3 text-xs font-medium tracking-wider text-left text-gray-800 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $index => $order)
                            <tr>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap print:hidden">{{ $order->id }}</td>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap">{{ $order->name }}<br><small>{{ $order->email }}<br>{{ $order->phone }}</small></td>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap">
                                    <ul>
                                        @foreach ($order->orderItems as $orderItem)
                                            <li>{{ $orderItem->quantity }} x {{ $orderItem->product->title }} ({{ strtoupper($orderItem->variation) }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap">{{ $order?->team?->title }}</td>
                                <td class="px-3 py-4 text-xs text-gray-800 whitespace-nowrap">{{ $order->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="my-6 opacity-10">

            <h2 class="my-4 text-xl font-bold">Ukupno narudžbi: {{ $orders->count() }}</h2>

            <div class="mt-4 text-xs">
                <div class="grid grid-cols-2 gap-4 mt-4">
                    @foreach ($summary as $summaryItem)
                        <div class="p-4 bg-white rounded-lg shadow-sm">
                            @php
                                $total = 0;
                            @endphp
                            <h3 class="text-lg font-bold">{{ $summaryItem['product']->title }}</h3>
                            <ul class="pl-4 mt-2 space-y-1 list-disc">
                                @foreach ($summaryItem['items'] as $size => $quantity)
                                    <li class="text-xs">{{ strtoupper($size) }} ({{ $quantity }})</li>
                                    @php
                                        $total += $quantity;
                                    @endphp
                                @endforeach
                            </ul>

                            <p class="mt-2 font-bold text-md">Ukupno: {{ $total }}</p>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="mt-8 max-w-[800px]">
                <h2 class="mb-4 text-xl font-bold">Glasovi za ekipe</h2>

                <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                    <table class="w-full text-sm table-auto">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 font-medium tracking-wider text-left text-gray-500 uppercase">Ekipa</th>
                                <th class="px-4 py-3 font-medium tracking-wider text-right text-gray-500 uppercase">Glasovi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($votes as $position => $vote)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium">{{ $position + 1 }}. {{ $vote['title'] }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="px-3 py-1 text-sm font-bold rounded-full bg-secondary">{{ $vote['count'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
