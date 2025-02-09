<x-waiter.layout>
    <x-waiter.navbar>
        <x-waiter.table-header :table="'Table ' . session('tableNo')"  :trackOrder="'Order History '">
            <div class="relative flex flex-col">
                <div class="mb-2">
                    <hr class="mt-3">

                    @php
                        $selectedOrder = request()->orderID ? $orders->firstWhere('orderID', request()->orderID) : null;
                    @endphp
                    {{--dd($selectedOrder)--}}
                    @if ($selectedOrder)
                        <div class="border rounded-lg p-4 mb-6">
                            @foreach ($selectedOrder->orderItems as $item)
                                @php
                                    $subtotal = $selectedOrder->totalAmount;
                                    $tax = $subtotal * 0.06; // 6% tax
                                    $serviceCharge = $subtotal * 0.10; // 10% service charge
                                    $total = $subtotal + $tax + $serviceCharge;
                                @endphp

                                <div class="flex gap-x-10 items-center py-4">
                                    <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                        @if (!empty($item->products->image))
                                            <img class="w-full h-full rounded-lg object-cover" src="{{ asset($item->products->image) }}" alt="{{ $item->products->name }}">
                                        @else
                                            <p>No Image</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center w-1/2 justify-between">
                                        <div class="space-y-2 text-sm">
                                            <p class="font-semibold">{{ $item->products->name ?? 'Unknown Product' }}</p>
                                            <p>RM {{ number_format($item->products->price ?? 0, 2) }}</p>

                                            @if (!empty($item->remark))
                                                @php $remarks = json_decode($item->remark, true); @endphp
                                                @if (is_array($remarks))
                                                    @foreach ($remarks as $optionName => $optionValues)
                                                        <p>{{ $optionName }}: {{ implode(', ', (array) $optionValues) }}</p>
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                        <div class="ml-2 flex border py-1 px-2 rounded-lg bg-[#efefef] text-center items-center">
                                            <small>x</small>
                                            <p class="ml-1">{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <hr class="mx-6">
                        </div>

                        <div class="w-full sticky bottom-0 flex flex-col px-6 font-pop pb-6 bg-white">
                                <div class="mt-12">
                                    <p class="font-semibold">Payment Summary</p>
                                </div>

                                <div class="flex flex-col mt-3 text-[#5B5B5B] gap-y-6">
                                    <div class="flex justify-between">
                                        <p>Subtotal</p>
                                        <p>RM {{ number_format($subtotal, 2) }}</p>
                                    </div>

                                    <div class="flex justify-between">
                                        <p>Tax 6%</p>
                                        <p>RM {{ number_format($tax, 2) }}</p>
                                    </div>

                                    <div class="flex justify-between">
                                        <p>Service Charge 10%</p>
                                        <p>RM {{ number_format($serviceCharge, 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col mt-4 gap-y-3">
                                    <hr class="border border-dashed">
                                    <div class="flex justify-between font-semibold">
                                        <p>Total</p>
                                        <p>RM {{ number_format($total, 2) }}</p>
                                    </div>
                                    <hr class="border border-dashed">
                                </div>

                                <div class="bg-blue-button rounded-lg text-white flex items-center justify-center py-4 gap-x-2 mt-8">
                                    <a href="{{ route('menu') }}">Back To Home</a>
                                </div>
                            </div>
                    @else
                        <p class="text-center text-gray-500 mt-20">Order not found.</p>
                    @endif
                </div>
            </div>
        </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>