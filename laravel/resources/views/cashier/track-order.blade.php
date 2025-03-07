<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen relative">
            <div class="w-full p-6 mt-25">
                <div class="mt-2">
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="orderList">
                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)
                                @php
                                    // Check if this order has any payments
                                    $isPaid = $order->payments->isNotEmpty();
                                    $statusClass = $isPaid ? 'text-green-500 bg-green-100' : 'text-red-500 bg-red-100';
                                    $statusText = $isPaid ? 'Completed' : 'Pending';
                                @endphp

                                <a href="{{ route('orderSummary', ['orderID' => $order->orderID]) }}"
                                   class="cursor-pointer bg-white p-4 shadow rounded-lg hover:shadow-lg transition">
                                    <div class="flex justify-between items-center mb-4">
                                        <p class="text-gray-700 font-bold">Table {{ $order->tableNo }}</p>
                                        <p class="{{ $statusClass }} px-3 py-2 text-sm rounded-full font-bold">
                                            {{ $statusText }}
                                        </p>
                                    </div>
                                    <hr class="mb-2">
                                    <p class="text-gray-700"><strong>Order No:</strong> {{ $order->orderID }}</p>
                                    <p class="text-gray-700"><strong>Total Amount:</strong> {{ $order->totalAmount }}</p>
                                    <p class="text-gray-700"><strong>Remark:</strong> {{ $order->remark ?: '-' }}</p>
                                    <p class="text-gray-500 text-sm mt-2"><strong>Last Order:</strong> {{ $order->created_at }}</p>
                                </a>
                            @endforeach
                        @else
                            <p class="text-center text-gray-500 text-lg font-semibold mt-10">Currently No Orders</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>
