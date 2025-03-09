<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col mt-24">
            <x-waiter.table-header :table="'Table ' . session('tableNo')"  :trackOrder="'Order History '">
                <div class="relative flex flex-col">
                    <div class="mb-2">
                        <hr>

                        @php
                            $selectedOrder = request()->orderID ? $orders->firstWhere('orderID', request()->orderID) : null;
                        @endphp

                        @if ($selectedOrder)
                            <div class="border rounded-lg p-4 mb-96">
                                @foreach ($selectedOrder->orderItems as $item)
                                    @php
                                        $subtotal = $selectedOrder->totalAmount;
                                        $tax = $subtotal * 0.06; // 6% tax
                                        $serviceCharge = $subtotal * 0.10; // 10% service charge
                                        $total = $subtotal + $tax + $serviceCharge;
                                    @endphp

                                    <div class="flex gap-x-10 items-center py-4 p-2">
                                        <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                            @if (!empty($item->products->image))
                                                <img class="w-full h-full rounded-lg object-cover" src="{{ asset($item->products->image) }}" alt="{{ $item->products->name }}">
                                            @else
                                                <p>No Image</p>
                                            @endif
                                        </div>

                                        <div class="flex items-center w-1/2 justify-between">
                                            <div class="space-y-2 text-sm">
                                                <p class="text-base font-bold text-zinc-700">{{ $item->products->name ?? 'Unknown Product' }}</p>

                                                @php
                                                    $options = [];
                                                    $takeaway = false;

                                                    if (!empty($item->remark)) {
                                                        $remarks = json_decode($item->remark, true);

                                                        if (isset($remarks['options']) && is_array($remarks['options'])) {
                                                            foreach ($remarks['options'] as $values) {
                                                                $options = array_merge($options, (array) $values);
                                                            }
                                                        }

                                                        if (isset($remarks['takeaway'])) {
                                                            $takeaway = $remarks['takeaway'];
                                                        }
                                                    }

                                                    $orderType = $takeaway
                                                        ? '<strong class="font-bold text-red-500">[ Takeaway ]</strong>'
                                                        : '<strong class="font-bold text-indigo-500">[ Dine In ]</strong>';
                                                @endphp

                                                <p class="text-sm text-gray-500">
                                                    {!! $orderType !!}
                                                    @if (!empty($options))
                                                        - {!! implode(', ', array_unique($options)) !!}
                                                    @endif
                                                </p>

                                                <p class="text-sm">{{ '- RM ' . number_format($item->products->price ?? 0, 2) }}</p>
                                            </div>
                                            <div class="flex items-center justify-center flex-col">
                                                <div class="border w-8 h-8 ml-4 rounded-full bg-indigo-500 flex items-center justify-center">
                                                    <p class="text-white">{{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="w-full fixed bottom-0 flex flex-col px-6 pb-6 bg-white">
                                <div class="mt-6">
                                    <p class="font-semibold text-lg">Payment Summary</p>
                                </div>

                                <div class="flex flex-col mt-4 text-gray-600 gap-y-2">
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
                                    <hr class="border-t-4 border-dotted border-gray-200">
                                    <div class="flex justify-between font-semibold">
                                        <p>Total</p>
                                        <p>RM {{ number_format($total, 2) }}</p>
                                    </div>
                                    <hr class="border-t-4 border-dotted border-gray-200">
                                </div>

                                <div class="flex gap-x-4 justify-center items-center">

                                    @if ($selectedOrder->status != 'Completed')
                                        <div class="bg-indigo-500 rounded-lg text-white flex items-center justify-center py-4 px-6 mt-4">
                                            <button onclick="openConfirmCompleteModal()">Mark as Completed</button>
                                        </div>

                                    @else
                                        <div class="bg-light-gray rounded-lg text-white flex items-center justify-center text-center py-4 px-6 mt-4">
                                            <button title="Order Completed!">Order Completed</button>
                                        </div>
                                    @endif

                                    <div class="bg-gray-500 rounded-lg text-white flex items-center justify-center text-center py-4 px-6 mt-4">
                                        <a href="{{ route('menu') }}">Back To Home</a>
                                    </div>
                                </div>

                                <div id="confirmCompleteOverlay" class="hidden fixed inset-0 z-10 bg-gray-500/75 transition-opacity" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div id="confirmCompleteModal" class="fixed inset-0 flex items-center justify-center">
                                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                            <div class="bg-white px-12 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                                        <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">Order Completed?</h3>
                                                        <p class="mt-2 text-sm text-gray-500">Do you sure the Order is completed?</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                <form action="{{ route('orders.update-status') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input name="completedOrderID" type="number" class="hidden" value="{{$selectedOrder->orderID}}">
                                                    <button type="submit" id="orderCompletedButton" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Yes</button>
                                                </form>
                                                <button id="cancelModal" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-gray-500 mt-20">Order not found.</p>
                        @endif
                    </div>
                </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const overlay = document.getElementById("confirmCompleteOverlay");
        const modal = document.getElementById("confirmCompleteModal");

        function openModal() {
            overlay.classList.remove("hidden");
        }

        function closeModal() {
            overlay.classList.add("hidden");
        }

        document.getElementById("cancelModal").addEventListener("click", closeModal);
        document.getElementById("orderCompletedButton").addEventListener("click", closeModal);

        window.openConfirmCompleteModal = openModal;
    });
</script>
