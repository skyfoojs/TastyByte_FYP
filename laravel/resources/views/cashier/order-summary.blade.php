<x-cashier.layout>
    <x-cashier.navbar>
        <div class="w-3/4 p-6 mt-26">
            @php
                $selectedOrder = request()->orderID ? $orders->firstWhere('orderID', request()->orderID) : null;
            @endphp

            <div class="space-y-4">
                @if ($selectedOrder)
                    @php
                        $firstItem = $selectedOrder->orderItems->first();
                    @endphp

                    @if ($firstItem)
                        <h2 class="text-xl font-bold mb-6 p-2">Order History - Table {{ $firstItem->table->tableNo }}</h2>
                    @endif

                    @foreach ($selectedOrder->orderItems as $item)
                        <div class="flex items-center justify-between bg-white p-4 shadow rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-28 h-28 border rounded-lg flex items-center justify-center">
                                    @if (!empty($item->products->image))
                                        <img class="w-full h-full rounded-lg object-cover" src="{{ asset($item->products->image) }}" alt="Image Not Available">
                                    @else
                                        <p>No Image</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-lg">{{ $item->products->name }}</p>
                                    @if (!empty($item->remark))
                                        @php
                                            $remarkData = json_decode($item->remark, true);
                                            $options = $remarkData['options'] ?? [];
                                            $takeaway = $remarkData['takeaway'] ?? false;

                                            $remarks = [];

                                            foreach ($options as $optionName => $values) {
                                                if (!empty($values)) {
                                                    $remarks[] = implode(', ', $values);
                                                }
                                            }
                                        @endphp

                                        @if ($takeaway)
                                            <p class="text-sm text-gray-500">Takeaway: Yes</p>
                                        @endif

                                        @if (!empty($remarks))
                                            <p class="text-sm text-gray-500">{{ implode(', ', $remarks) }}</p>
                                        @endif
                                    @endif
                                    <p class="mt-2 text-gray-600">- RM {{ number_format($item->products->price ?? 0, 2) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="border w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white mb-4">{{ $item->quantity }}</span>
                                <button class="px-6 py-2 bg-gray-200 rounded-full text-sm tracking-wide">Split</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <x-cashier.sidebar>
        </x-cashier.sidebar>
    </x-cashier.navbar>
</x-cashier.layout>
