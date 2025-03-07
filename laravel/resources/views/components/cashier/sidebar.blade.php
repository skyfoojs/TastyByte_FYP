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
        <h2 class="font-semibold text-lg">Table {{ session('tableNo') }} - Cart Summary</h2>
        <hr class="mt-4">

        <div class="flex-1 overflow-y-auto mt-6 mb-6">
            @if (session('cart'))
                @foreach (session('cart') as $cartKey => $cartItem)
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

                        <div class="flex items-center justify-center flex-col">
                            <div class="border w-8 h-8 mr-2 rounded-full bg-indigo-500 flex items-center justify-center">
                                <p class="text-white">{{ $cartItem['quantity'] }}</p>
                            </div>

                            <button class="w-8 h-8 mr-2 mt-4 text-red-600 remove-cart-item flex items-center justify-center" data-key="{{ $cartKey }}">
                                <i class="bx bx-trash text-xl"></i>
                            </button>
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

            <form action="{{ route('cashier.addOrder.post') }}" method="POST">
                @csrf
                <button class="w-full bg-indigo-500 text-white py-2 mt-4 rounded" type="submit">Place Order</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".remove-cart-item").forEach((button) => {
                button.addEventListener("click", function () {
                    let cartKey = this.getAttribute("data-key");
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                    fetch("{{ route('cashierCart.remove') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ cartKey: cartKey })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.redirect) {
                                    location.reload()
                                } else {
                                    alert("Error occurred while removing the item.");
                                }
                            }
                        })
                        .catch(async (error) => {
                            console.error("Error:", error);

                            if (error.response) {
                                const errorText = await error.response.text();
                                alert("Error occurred: " + errorText);
                            } else {
                                alert("An unknown error occurred while removing the item.");
                            }
                        });
                });
            });
        });
    </script>

@elseif ($routeName === 'orderSummary')
    @php
        $checkout = session('checkout', []);
        $orderID = $checkout['orderID'] ?? 'Error';
        $subtotal = $checkout['subtotal'] ?? 0;
        $tax = $checkout['tax'] ?? 0;
        $serviceCharge = $subtotal * 0.10;
        $total = $checkout['total'] ?? 0;
        $tableNo = $checkout['tableNo'] ?? 'Error';
    @endphp

    <!-- Cashier Sidebar -->
    <div class="w-1/4 bg-white p-6 shadow-lg fixed right-0 top-26 h-[calc(100%-6rem)] flex flex-col justify-between">
        <div class="overflow-y-auto flex-1">
            <h2 class="font-semibold text-lg mb-2">Table {{ $tableNo }} - Order Summary</h2>
            <p class="text-gray-500">Order ID: {{ $orderID }}</p>
            <p class="text-gray-500">Order Date: 2025-05-20 13:14</p>

            <hr class="mt-4 mb-2">

            <div class="pt-4">
                <h3 class="font-semibold text-lg mb-2">Payment Method</h3>
                <div class="space-y-3">
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="cash"
                               class="w-5 h-5 text-indigo-500 focus:ring-0 border-gray-300 rounded-full"
                               onchange="updatePaymentMethod(this)" checked>
                        <span>Cash</span>
                    </label>
                    <label class="flex items-center space-x-4 cursor-pointer">
                        <input type="radio" name="paymentMethod" value="credit_card"
                               class="w-5 h-5 text-indigo-500 focus:ring-0 border-gray-300 rounded-full"
                               onchange="updatePaymentMethod(this)">
                        <span>Credit/ Debit Card</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 mt-4">
                <h3 class="font-semibold text-lg mb-2">Voucher</h3>
                <form id="voucherForm">
                    @csrf
                    <input type="text" name="voucher_code" id="voucherCode" placeholder="Enter voucher code"
                           class="border border-gray-300 rounded-lg px-3 py-2 flex-1 mr-4 focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg">Apply</button>
                </form>
                <p id="voucherMessage" class="text-red-500 mt-2"></p>
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

            @if (session('checkout.isPaid', false))
                <button disabled class="w-full bg-gray-400 text-white py-2 mt-4 rounded cursor-not-allowed">
                    Paid
                </button>
            @else
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="orderID" value="{{ request()->orderID }}">
                    <input type="hidden" name="paymentMethod" id="selectedPaymentMethod" value="cash">
                    <input type="hidden" name="voucher_code" id="hiddenVoucherCode" value="">

                    <button type="submit" class="w-full bg-indigo-500 text-white py-2 mt-4 rounded">
                        Checkout
                    </button>
                </form>
            @endif

        </div>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updatePaymentMethod(radio) {
            document.getElementById('selectedPaymentMethod').value = radio.value;
        }

        document.getElementById('voucherForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let code = document.getElementById('voucherCode').value;

            fetch("{{ route('applyVoucher') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ voucher_code: code })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('voucherMessage').textContent = "Voucher applied successfully!";
                        document.getElementById('hiddenVoucherCode').value = code;
                        document.getElementById('totalAmount').textContent = "RM " + data.new_total.toFixed(2);
                    } else {
                        document.getElementById('voucherMessage').textContent = "Invalid voucher code.";
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        document.querySelectorAll('input[name="paymentMethod"]').forEach((radio) => {
            radio.addEventListener("change", function() {
                updatePaymentMethod(this);
            });
        });
    });
</script>
