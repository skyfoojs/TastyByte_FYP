<div class="w-1/4 bg-white p-6 shadow-lg fixed right-0 top-26 h-[calc(100%-6rem)] flex flex-col">
    <h2 class="font-semibold text-lg">Table {{ session('tableNo') }} Summary</h2>

    <div class="flex-1 overflow-y-auto mt-4">
        <!-- TODO: Order Product -->
    </div>

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
            <button class="w-full bg-indigo-400 text-white py-2 mt-4 rounded">Place Order</button>
        </a>
    </div>
</div>
