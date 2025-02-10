<div class="w-1/4 bg-white p-6 shadow-lg fixed right-0 top-26 h-[calc(100%-6rem)] flex flex-col">
    <h2 class="font-semibold text-lg">Table {{ session('tableNo') }} Summary</h2>

    <hr class="mt-4">

    <div class="flex-1 overflow-y-auto mt-6">
        @php
            //session()->forget('cart');
        @endphp

        @if (session('cart'))
            @foreach (session('cart') as $cartItem)
                <div class="flex gap-x-4 mb-6">
                    <!-- Image -->
                    <div class="border w-24 h-24 rounded-lg flex items-center justify-center">
                        @if (!empty($cartItem['image']))
                            <img class="w-full h-full rounded-lg object-cover" src="{{ asset($cartItem['image']) }}" alt="Image Not Available">
                        @else
                            <p>No Image</p>
                        @endif
                    </div>

                    <!-- Name and Price at the top -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-base font-bold text-zinc-700">{{ $cartItem['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ 'RM ' . $cartItem['price'] }}</p>

                            <!-- Options -->
                            @foreach ($cartItem['options'] as $optionName => $optionValues)
                                <p class="text-xs text-gray-600">{{ $optionName }}:<br> {{ implode(', ', $optionValues) }}</p>
                            @endforeach
                        </div>
                    </div>

                    <!-- Centered Quantity Box -->
                    <div class="flex items-center justify-center">
                        <div class="border w-8 h-8 mr-2 rounded-full bg-indigo-500 flex items-center justify-center">
                            <p class="text-white">{{ $cartItem['quantity'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <hr>

    <div class="pt-4">
        @php
            $subtotal = array_reduce(session('cart', []), function($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);
            $tax = $subtotal * 0.06; // 6% tax
            $serviceCharge = $subtotal * 0.10; // 10% service charge
            $total = $subtotal + $tax + $serviceCharge;
        @endphp

        <div class="flex justify-between text-gray-600">
            <span>Subtotal</span>
            <span>{{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Tax 6%</span>
            <span>{{ number_format($tax, 2) }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Service Charge 10%</span>
            <span>{{ number_format($serviceCharge, 2) }}</span>
        </div>
        <hr class="border-t-4 mt-4 mb-4 border-dotted border-gray-200">
        <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>{{ number_format($total, 2) }}</span>
        </div>
        <hr class="border-t-4 mt-4 border-dotted border-gray-200">
        <a href="{{ route('orderSummary') }}">
            <button class="w-full bg-indigo-500 text-white py-2 mt-4 rounded">Place Order</button>
        </a>
    </div>
</div>
