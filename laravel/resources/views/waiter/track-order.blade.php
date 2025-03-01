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
                        @foreach ($orders as $order)
                            <a href="{{ route('orderHistory', ['orderID' => $order->orderID]) }}"
                               class="order-item" data-table="{{ $order->tableNo }}">
                                <div class="bg-white w-full p-5 rounded-xl mt-10">
                                    <div class="flex">
                                        <div class="space-y-3 ml-3">
                                            <div>
                                                <p><span class="font-semibold">Table:</span>&nbsp;&nbsp;{{ $order->tableNo }}</p>
                                                <p><span class="font-semibold">Status:</span>&nbsp;&nbsp;{{ $order->status }}</p>
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

        orders.forEach(order => {
            if (selectedTable === 'all' || order.dataset.table === selectedTable) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    });
</script>
