<x-waiter.layout>
    <x-waiter.navbar>
        <x-waiter.table-header :table="'Table'" :trackOrder="'Choose '">
            <div class="flex flex-col pb-8">
                <div class="flex justify-center items-center mt-4">
                    <select id="tableFilter" class="w-72 rounded-2xl py-1 px-4 bg-white">
                        <option value="all">All Tables</option>
                        @foreach ($orders->unique('tableNo')->sortBy('tableNo') as $order)
                            <option value="{{ $order->tableNo }}">{{ $order->tableNo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="px-8" id="orderContainer">
                    @if ($orders->isNotEmpty())
                        @php
                            [$pendingOrders, $completedOrders] = $orders->partition(function ($order) {
                                return strtolower($order->status) === 'pending';
                            });
                        @endphp

                        <p class="mt-5 text-xl">Pending</p>

                        {{-- Pending Orders First --}}
                        @if ($pendingOrders->isNotEmpty())
                            @foreach ($pendingOrders as $order)
                                <a href="{{ route('orderHistory', ['orderID' => $order->orderID]) }}"
                                class="order-item " data-table="{{ $order->tableNo }}" data-status="pending">
                                    <div class="bg-white w-full p-5 rounded-xl mt-5">
                                        <div class="flex">
                                            <div class="space-y-3 ml-3">
                                                <div>
                                                    <p><span class="font-semibold">Table:</span>&nbsp;&nbsp;{{ $order->tableNo }}</p>
                                                    <p><span class="font-semibold">Status:</span>&nbsp;&nbsp;<span class="text-red-500">{{ $order->status }}</span></p>
                                                    <p><span class="font-semibold">Total Amount:</span>&nbsp;&nbsp;{{ $order->totalAmount }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[#919191] text-sm">
                                                        <span>Last Order:</span>&nbsp;&nbsp;{{ $order->created_at }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                                <p id="noPendingMessage" class="text-center text-gray-500 mt-10" style="display: none;">Currently No Pending Orders</p>
                            @else
                                <p class="text-center text-gray-500 mt-20">Currently No Pending Orders</p>
                        @endif

                        <p class="mt-10 text-xl">Completed</p>

                        {{-- Completed Orders Below --}}
                        @if ($completedOrders->isNotEmpty())
                            @foreach ($completedOrders as $order)
                                <a href="{{ route('orderHistory', ['orderID' => $order->orderID]) }}"
                                class="order-item" data-table="{{ $order->tableNo }}" data-status="completed">
                                    <div class="bg-white w-full p-5 rounded-xl mt-5">
                                        <div class="flex">
                                            <div class="space-y-3 ml-3">
                                                <div>
                                                    <p><span class="font-semibold">Table:</span>&nbsp;&nbsp;{{ $order->tableNo }}</p>
                                                    <p><span class="font-semibold">Status:</span>&nbsp;&nbsp;<span class="text-green-500">{{ $order->status }}</span></p>
                                                    <p><span class="font-semibold">Total Amount:</span>&nbsp;&nbsp;{{ $order->totalAmount }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[#919191] text-sm">
                                                        <span>Last Order:</span>&nbsp;&nbsp;{{ $order->created_at }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                                <p id="noCompletedMessage" class="text-center text-gray-500 mt-10" style="display: none;">Currently No Completed Orders</p>
                            @else
                                <p class="text-center text-gray-500 mt-20">Currently No Completed Orders</p>
                        @endif
                    @else
                        <p class="text-center text-gray-500 mt-20">Currently No Orders</p>
                    @endif
                </div>
            </div>
        </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>

<script>
    document.getElementById('tableFilter').addEventListener('change', function () {
        let selectedTable = this.value;
        let orders = document.querySelectorAll('.order-item');

        let hasPending = false;
        let hasCompleted = false;

        orders.forEach(order => {
            if (selectedTable === 'all' || order.dataset.table === selectedTable) {
                order.style.display = 'block';
                if (order.dataset.status === 'pending') hasPending = true;
                if (order.dataset.status === 'completed') hasCompleted = true;
            } else {
                order.style.display = 'none';
            }
        });

        // Show or hide the "No Pending Orders" message
        let pendingMessage = document.getElementById('noPendingMessage');
        if (pendingMessage) {
            pendingMessage.style.display = hasPending ? 'none' : 'block';
        }

        // Show or hide the "No Completed Orders" message
        let completedMessage = document.getElementById('noCompletedMessage');
        if (completedMessage) {
            completedMessage.style.display = hasCompleted ? 'none' : 'block';
        }
    });
</script>