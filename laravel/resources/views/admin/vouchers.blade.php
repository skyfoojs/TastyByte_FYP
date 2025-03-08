<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Voucher</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openVoucherAddModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-plus-circle'></i>
                            <span>Add Voucher</span>
                        </button>

                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="voucherTableContainer" class="bg-white p-6 rounded-3xl shadow-lg overflow-x-auto flex flex-col justify-between" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="voucherTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Voucher ID</th>
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

                <div>
                {{ $vouchers->appends(request()->query())->links() }}
                </div>
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
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('admin-vouchers') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="voucherEditModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Edit Voucher</h2>
                <hr class="py-2">
                <form action="{{ route('editVoucher.post') }}" method="POST">
                    <input type="hidden" id="voucherID" name="voucherID">
                    @csrf
                    @method('PUT')
                    <label class="block text-gray-700 text-sm font-medium mt-4">Voucher Code (6-12 characters) <span class="text-red-500">*</span></label>
                    <input minlength="6" maxlength="12" name="editCode" type="text" id="editCode" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Number of Usage <span class="text-red-500">*</span></label>
                            <input name="editUsage" type="number" id="editUsage" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Voucher Type <span class="text-red-500">*</span></label>
                            <select name="editType" id="editType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Type</option>
                                <option value="Percentage">Percentage</option>
                                <option value="Amount">Amount</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Voucher Value <span class="text-red-500">*</span></label>
                            <input min="0" name="editVoucherValue" type="numeric" id="editVoucherValue" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Single Use <span class="text-red-500">*</span></label>
                            <select name="editSingleUse" id="editSingleUse" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select True or False</option>
                                <option value="False">False</option>
                                <option value="True">True</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Start Date <span class="text-red-500">*</span></label>
                            <input name="editStartDate" type="datetime-local" id="editStartDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Expired Date <span class="text-red-500">*</span></label>
                            <input name="editExpiredDate" type="datetime-local" id="editExpiredDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeVoucherEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="editVoucherButton" name="editVoucherButton" value="Edit Voucher" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Update Voucher</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="voucherAddModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add Voucher</h2>
                <hr class="py-2">
                <form action="{{ route('addVoucher.post') }}" method="POST">
                    @csrf
                    <label class="block text-gray-700 text-sm font-medium mt-4">Voucher Code (6-12 characters) <span class="text-red-500">*</span></label>
                    <input minlength="6" maxlength="12" name="code" type="text" id="code" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Number of Usage <span class="text-red-500">*</span></label>
                            <input name="usage" type="number" id="usage" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium mt-4">Voucher Type <span class="text-red-500">*</span></label>
                            <select name="type" id="type" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select Type</option>
                                <option value="Percentage">Percentage</option>
                                <option value="Amount">Amount</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Voucher Value <span class="text-red-500">*</span></label>
                            <input min="0" name="voucherValue" type="numeric" id="voucherValue" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Single Use <span class="text-red-500">*</span></label>
                            <select name="singleUse" id="singleUse" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                                <option value="">Select True or False</option>
                                <option value="False">False</option>
                                <option value="True">True</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Start Date <span class="text-red-500">*</span></label>
                            <input name="startDate" type="datetime-local" id="startDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Expired Date <span class="text-red-500">*</span></label>
                            <input name="expiredDate" type="datetime-local" id="expiredDate" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeVoucherAddModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="addVoucherButton" name="addVoucherButton" value="Add Voucher" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Add Voucher</button>
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

function openModal() {
    const modal = document.getElementById('userModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function openVoucherAddModal() {
    const modal = document.getElementById('voucherAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeVoucherAddModal() {
    const modal = document.getElementById('voucherAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function openVoucherEditModal(id, code, type, singleUse, usage, value, startDate, expiredDate) {
    const modal = document.getElementById('voucherEditModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    document.getElementById('voucherID').value = id;
    document.getElementById('editCode').value = code;
    document.getElementById('editType').value = type;
    document.getElementById('editSingleUse').value = singleUse;
    document.getElementById('editUsage').value = usage;
    document.getElementById('editVoucherValue').value = value;
    document.getElementById('editStartDate').value = startDate;
    document.getElementById('editExpiredDate').value = expiredDate;

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeVoucherEditModal() {
    const modal = document.getElementById('voucherEditModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        clearModalFields();
    }, 300);
}

function clearModalFields() {
    document.getElementById('voucherID').value = '';
    document.getElementById('editCode').value = '';
    document.getElementById('editType').value = '';
    document.getElementById('editSingleUse').value = '';
    document.getElementById('editUsage').value = '';
    document.getElementById('editVoucherValue').value = '';
    document.getElementById('editStartDate').value = '';
    document.getElementById('editExpiredDate').value = '';
}
</script>