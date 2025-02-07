<x-waiter.layout>
    <x-waiter.navbar>
            <x-waiter.table-header :table="session('tableNo') . ' Summary'">
                @php
                //ession()->forget('cart');
                @endphp
                <div class="relative flex flex-col">
                    <div class="mt-6 mb-2">
                        <hr class="mt-3">
                        <!-- Loop through products under the category -->
                        @if (session('cart'))
                            @foreach (session('cart') as $cartItem)
                                <div class="flex gap-x-10 items-center py-4 pl-8">
                                    <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                        @if (!empty($cartItem['image']))
                                            <img class="w-full h-full rounded-lg object-cover" src="{{ asset($cartItem['image']) }}" alt="Image Not Available">
                                        @else
                                            <p>No Image</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center w-1/2 justify-between">
                                        <div class="space-y-2 text-sm">
                                            <p>{{ $cartItem['name'] }}</p>
                                            <p>{{ 'RM ' . $cartItem['price'] }}</p>

                                            <!-- Loop through options -->
                                            @foreach ($cartItem['options'] as $optionName => $optionValues)
                                                <p>{{ $optionName }}:<br> {{ implode(', ', $optionValues) }}</p>
                                            @endforeach
                                        </div>

                                        <div class="ml-2 flex border py-1 px-2 rounded-lg bg-[#efefef] text-center items-center">
                                            <small>x</small>
                                            <p class="ml-1">{{ $cartItem['quantity'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="w-full sticky bottom-0 flex flex-col px-6 font-pop pb-6 bg-white">
                                <hr>
                                <div class="mt-12">
                                    <p class="font-semibold">Payment Summary</p>
                                </div>

                                <div class="flex flex-col mt-3 text-[#5B5B5B] gap-y-6">
                                    <div class="flex justify-between">
                                        <p>Subtotal</p>
                                        <p>RM {{ $subTotal = number_format(array_reduce(session('cart'), function($carry, $item) {
                                        return $carry + ($item['price'] * $item['quantity']);
                                    }, 0), 2) }}</p>
                                    </div>

                                    <div class="flex justify-between">
                                        <p>Tax 6%</p>
                                        <p>RM {{ $tax = number_format($subTotal * 0.06, 2) }}</p>
                                    </div>

                                    <div class="flex justify-between">
                                        <p>Service Charge 10%</p>
                                        <p>RM {{ $serviceCharge = number_format($tax * 0.10, 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex flex-col mt-4 gap-y-3">
                                    <hr class="border border-dashed">
                                    <div class="flex justify-between font-semibold">
                                        <p>Total</p>
                                        <p>RM {{ $total = $subTotal + $tax + $serviceCharge }}</p>
                                    </div>
                                    <hr class="border border-dashed">
                                </div>

                                <div class="bg-blue-button rounded-lg text-white flex items-center justify-center py-4 gap-x-2 mt-8">
                                    <button>Place Order</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>
