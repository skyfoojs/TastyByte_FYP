<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col mt-24">
            <x-waiter.table-header :table="'Table ' . session('tableNo')" :trackOrder="'Summary'">
                @php
                    //session()->forget('cart');
                @endphp
                <div class="flex flex-col">
                    <hr class="mt-3">
                    <!-- Loop through products under the category -->
                    @if (session('cart'))
                        <div class="mb-96">
                            @foreach (session('cart') as $cartKey => $cartItem)
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
                                            <p class="text-base font-bold text-zinc-700">{{ $cartItem['name'] }}</p>
                                            <p>{{ $cartItem['takeaway'] ? 'Takeaway' : 'Dine-In' }}</p>

                                            <!-- Loop through options -->
                                            @foreach ($cartItem['options'] as $optionName => $optionValues)
                                                <p>{{ $optionName }}:<br> {{ implode(', ', $optionValues) }}</p>
                                            @endforeach

                                            <p class="text-sm">{{ '- RM ' . $cartItem['price'] }}</p>
                                        </div>

                                        <div class="flex items-center justify-center flex-col">
                                            <div class="border w-8 h-8 mr-2 rounded-full bg-indigo-500 flex items-center justify-center">
                                                <p class="text-white">{{ $cartItem['quantity'] }}</p>
                                            </div>

                                            <button class="w-8 h-8 mr-2 mt-4 text-red-600 remove-from-cart flex items-center justify-center" data-key="{{ $cartKey }}">
                                                <i class="bx bx-trash text-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mx-6">
                            @endforeach
                        </div>

                        <div class="w-full fixed bottom-0 flex flex-col px-6 font-pop pb-6 bg-white z-50">
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
                                <form action="{{ route('addOrder.post') }}" method="POST">
                                    @csrf
                                    <button type="submit">Place Order</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".remove-from-cart").forEach(button => {
            button.addEventListener("click", function () {
                let cartKey = this.getAttribute("data-key");
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                fetch("{{ route('cart.remove') }}", {
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
                                window.location.href = data.redirect; // Redirect first
                            } else {
                                location.reload(); // Refresh page if cart is not empty
                            }
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });


</script>
