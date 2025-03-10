@section('title', 'Admin Payments Page - TastyByte')

<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Payment</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="paymentTableContainer" class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto flex flex-col justify-between" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="paymentTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Payment ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Order ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Voucher ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Total Amount (RM)</th>
                        <th class="py-4 px-6 border-b border-gray-200">Payment Method</th>
                        <th class="py-4 px-6 border-b border-gray-200">Payment Date</th>
                        <th class="py-4 px-6 border-b border-gray-200">Payment Status</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center" id="voucherTableBody">
                        @if (!sizeof($payments))
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                        @endif

                            @foreach ($payments as $payment)
                            <tr class="">
                                <td class="p-3 mt-4">{{ $payment->paymentID }}</td>
                                <td class="p-3 mt-4">{{ $payment->orderID }}</td>
                                <td class="p-3 mt-4">{{ $payment->voucherID ?? 'No Voucher Used' }}</td>
                                <td class="p-3 mt-4">{{ $payment->totalAmount }}</td>
                                <td class="p-3 mt-4">{{ $payment->paymentMethod }}</td>
                                <td class="p-3 mt-4">
                                    <span class="font-semibold">{{ date('Y-m-d', strtotime($payment->created_at)) }}<br></span>
                                    <span class="text-gray-500">{{ date('H:i:s', strtotime($payment->created_at)) }}</span>
                                </td>
                                <td class="p-3 mt-4">{{ $payment->status }}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>

                <div>
                {{ $payments->appends(request()->query())->links() }}
                </div>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="paymentFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Payment</h2>
                <hr class="py-2">
                <form action="{{ route('filterPayments.get') }}" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="filterPaymentID">Payment ID</option>
                        <option value="filterOrderID">Order ID</option>
                        <option value="filterVoucherID">Voucher ID</option>
                        <option value="filterPaymentMethod">Voucher Method</option>
                        <option value="filterPaymentStatus">Payment Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('admin-payments') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>

<style>
.modal {
    transition: opacity 0.3s ease, transform 0.3s ease;
    opacity: 0;
    transform: scale(0.9);
    pointer-events: none;
}

.modal.show {
    opacity: 1;
    transform: scale(1);
    pointer-events: auto;
}
</style>

<script>
function openFilterModal() {
    const modal = document.getElementById('paymentFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeFilterModal() {
    const modal = document.getElementById('paymentFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}
</script>