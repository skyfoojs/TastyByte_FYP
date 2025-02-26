<x-cashier.layout>
    <x-cashier.navbar>
        <div class="p-12 mt-20">
            @if ($orders->isNotEmpty())
                @foreach ($orders as $order)
                    <a href="{{ route('orderSummary', ['orderID' => $order->orderID]) }}"
                       class="order-item" data-table="{{ $order->tableNo }}">
                        <div class="bg-white w-full p-5 rounded-xl mt-10">
                            <div class="flex">
                                <div class="space-y-3 ml-3">
                                    <div>
                                        <p><span class="font-semibold">Table:</span>&nbsp;&nbsp;{{ $order->tableNo }}</p>
                                        <p><span class="font-semibold">Status:</span>&nbsp;&nbsp;{{ $order->status }}</p>
                                        <p><span class="font-semibold">Total Amount:</span>&nbsp;&nbsp;{{ $order->totalAmount }}</p>
                                        <p><span class="font-semibold">Remark:</span>&nbsp;&nbsp;{{ $order->remark }}</p>
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
    </x-cashier.navbar>
</x-cashier.layout>
