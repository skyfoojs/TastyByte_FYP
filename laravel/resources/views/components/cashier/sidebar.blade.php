@php
    $subtotal = array_reduce(session('cart', []), function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);
    $tax = $subtotal * 0.06;
    $serviceCharge = $subtotal * 0.10;
    $total = $subtotal + $tax + $serviceCharge;

    $routeName = Route::currentRouteName();
@endphp

@if ($routeName === 'cashier.order')
    <!-- Cashier Sidebar -->
    <div class="w-1/4 bg-white p-6 shadow-lg fixed right-0 top-26 h-[calc(100%-6rem)] flex flex-col">
        <h2 class="font-semibold text-lg">Table {{ session('tableNo') }} Summary</h2>
        <hr class="mt-4">

        <div class="flex-1 overflow-y-auto mt-6">
            @if (session('cart'))
                @foreach (session('cart') as $cartItem)
                    <div class="flex gap-x-4 mb-6">
                        <div class="border w-24 h-24 rounded-lg flex items-center justify-center">
                            @if (!empty($cartItem['image']))
                                <img class="w-full h-full rounded-lg object-cover" src="{{ asset($cartItem['image']) }}" alt="Image Not Available">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="flex-1 flex flex-col justify-between">
                            <p class="text-base font-bold text-zinc-700">{{ $cartItem['name'] }}</p>
                            @if (!empty($cartItem['options']))
                                <p class="text-sm text-gray-500">{{ collect($cartItem['options'])->map(function($values, $name) { return implode(', ', $values); })->implode(', ') }}</p>
                            @endif
                            <p class="text-sm">{{ '- RM ' . $cartItem['price'] }}</p>
                        </div>

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
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>RM {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax 6%</span>
                <span>RM {{ number_format($tax, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Service Charge 10%</span>
                <span>RM {{ number_format($serviceCharge, 2) }}</span>
            </div>

            <hr class="border-t-4 mt-4 mb-4 border-dotted border-gray-200">

            <div class="flex justify-between font-semibold">
                <span>Total</span>
                <span>RM {{ number_format($total, 2) }}</span>
            </div>

            <hr class="border-t-4 mt-4 border-dotted border-gray-200">

            <a href="{{ route('orderSummary') }}">
                <button class="w-full bg-indigo-500 text-white py-2 mt-4 rounded">Place Order</button>
            </a>
        </div>
    </div>

@elseif ($routeName === 'orderSummary')
    <!-- Cashier Sidebar -->
    <div class="w-1/4 bg-white p-6 shadow-lg fixed right-0 top-26 h-[calc(100%-6rem)] flex flex-col justify-between">
        <div class="overflow-y-auto flex-1">
            <h2 class="font-semibold text-lg">Table {{ session('tableNo') }} Order Summary</h2>

            <hr class="mt-4 mb-2">

            <div class="pt-4">
                <h3 class="font-semibold text-lg mb-2">Payment Method</h3>
                <div class="space-y-3">
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="radio" name="payment" class="w-5 h-5 text-indigo-500 focus:ring-0 border-gray-300 rounded-full" checked>
                        <span>Cash</span>
                    </label>
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="radio" name="payment" class="w-5 h-5 text-indigo-500 focus:ring-0 border-gray-300 rounded-full">
                        <span>Credit/ Debit Card</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 mt-4">
                <h3 class="font-semibold text-lg mb-2">Voucher</h3>
                <form>
                    @csrf
                    <input type="text" name="voucher_code" placeholder="Enter voucher code"
                           class="border border-gray-300 rounded-lg px-3 py-2 flex-1 mr-4 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg">Apply</button>
                </form>
            </div>
        </div>

        <div class="pt-4 border-t">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>RM {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax 6%</span>
                <span>RM {{ number_format($tax, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Service Charge 10%</span>
                <span>RM {{ number_format($serviceCharge, 2) }}</span>
            </div>

            <hr class="border-t-4 mt-4 mb-4 border-dotted border-gray-200">

            <div class="flex justify-between font-semibold">
                <span>Total</span>
                <span>RM {{ number_format($total, 2) }}</span>
            </div>

            <hr class="border-t-4 mt-4 border-dotted border-gray-200">

            <a href="{{ route('orderSummary') }}">
                <button class="w-full bg-indigo-500 text-white py-2 mt-4 rounded">Checkout</button>
            </a>
        </div>
    </div>
@endif
