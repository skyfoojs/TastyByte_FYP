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

            <div id="paymentTableContainer" class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="paymentTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Payment ID</th>
                        <th class="py-4 px-6 border-b border-gray-200">Type</th>
                        <th class="py-4 px-6 border-b border-gray-200">Code</th>
                        <th class="py-4 px-6 border-b border-gray-200">Value</th>
                        <th class="py-4 px-6 border-b border-gray-200">Used Count</th>
                        <th class="py-4 px-6 border-b border-gray-200">Started On</th>
                        <th class="py-4 px-6 border-b border-gray-200">Expired On</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center" id="voucherTableBody">
                        @if (!sizeof($vouchers))
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                        @endif

                            @foreach ($vouchers as $voucher)
                            <tr class="">
                                <td class="p-3 mt-4">{{ $voucher->voucherID }}</td>
                                <td class="p-3 mt-4">{{ $voucher->type }}</td>
                                <td class="p-3 mt-4">{{ $voucher->code }}</td>
                                <td class="p-3 mt-4">{{ $voucher->value }}</td>
                                <td class="p-3 mt-4">{{ $voucher->usedCount }}</td>
                                <td class="p-3 mt-4">
                                    <span class="font-semibold">{{ date('Y-m-d', strtotime($voucher->startedOn)) }}<br></span>
                                    <span class="text-gray-500">{{ date('H:i:s', strtotime($voucher->startedOn)) }}</span>
                                </td>
                                <td class="p-3 mt-4">
                                    <span class="font-semibold">{{ date('Y-m-d', strtotime($voucher->expiredOn)) }}<br></span>
                                    <span class="text-gray-500">{{ date('H:i:s', strtotime($voucher->expiredOn)) }}</span>
                                </td>
                                <td class="p-3 mt-4 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openVoucherEditModal({{ $voucher->voucherID }}, '{{ $voucher->code }}', '{{ $voucher->type }}', '{{ $voucher->singleUse }}', {{ $voucher->usage }}, {{ $voucher->value }}, '{{ $voucher->startedOn }}', '{{ $voucher->expiredOn }}')">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <nav aria-label="Page navigation">
                    <ul class="flex space-x-2 mr-4">
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="px-4 py-2 border rounded-md {{ $i == request()->get('page', 1) ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }} hover:bg-indigo-600 hover:text-white transition">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor
                    </ul>
                </nav>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="voucherFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Voucher</h2>
                <hr class="py-2">
                <form action="{{ route('filterVouchers.get') }}" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="filterVoucherID">Voucher ID</option>
                        <option value="filterVoucherCode">Voucher Code</option>
                        <option value="filterType">Voucher Type</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeVoucherFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('admin-vouchers') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>
<script>
function openFilterModal() {
    const modal = document.getElementById('voucherFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeFilterModal() {
    const modal = document.getElementById('voucherFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}
</script>