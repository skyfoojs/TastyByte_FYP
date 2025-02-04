<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <div class="mx-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Inventory</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="openInventoryAddModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-plus-circle'></i>
                            <span>Add Inventory</span>
                        </button>

                        <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2">
                            <i class='bx bx-filter-alt'></i>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="inventoryTableContainer" class="bg-[#E6E6E6] p-6 rounded-3xl shadow-lg overflow-x-auto" style="height: 540px;">
                <table class="min-w-full table-auto border-collapse w-full" id="userTable">
                    <thead>
                    <tr class="text-gray-500 font-medium text-center">
                        <th class="py-4 px-6 border-b border-gray-200">Category</th>
                        <th class="py-4 px-6 border-b border-gray-200">Product</th>
                        <th class="py-4 px-6 border-b border-gray-200">Stock Level</th>
                        <th class="py-4 px-6 border-b border-gray-200">Minimum Level</th>
                        <th class="py-4 px-6 border-b border-gray-200">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 text-center" id="userTableBody">
                        @if (!sizeof($inventory))
                        <tr>
                            <td colspan="7" class="py-4">No records found.</td>
                        </tr>
                        @endif

                            @foreach ($inventory as $inventories)
                            <tr class="">
                                <td class="p-3 mt-4">{{ $inventories->name }}</td>
                                <td class="p-3 mt-4">{{ $inventories->product->name }}</td>
                                <td class="p-3 mt-4">{{ $inventories->stockLevel }}</td>
                                <td class="p-3 mt-4">{{ $inventories->minLevel }}</td>
                                <td class="p-3 mt-4 flex justify-center space-x-2">
                                    <button class="text-gray-500 hover:text-blue-600" onclick="openInventoryEditModal({{ $inventories->inventoryID }}, '{{ $inventories->name }}', '{{ $inventories->product->name }}', {{ $inventories->stockLevel }}, {{ $inventories->minLevel }})">
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

                    </ul>
                </nav>
            </div>
        </section>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="inventoryFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Inventory</h2>
                <hr class="py-2">
                <form action="" method="GET">
                    <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="userID">User ID</option>
                        <option value="username">Username</option>
                        <option value="fullName">Full Name</option>
                        <option value="phone">Phone</option>
                        <option value="email">Email</option>
                        <option value="gender">Gender</option>
                        <option value="membership">Membership Status</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeInventoryFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="#" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="inventoryEditModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Edit Inventory</h2>
                <hr class="py-2">
                <form action="{{ route('editInventory.post') }}" method="POST">
                    <input type="hidden" id="inventoryID" name="inventoryID">
                    @csrf
                    @method('PUT')
                    <label class="block text-gray-700 text-sm font-medium mt-4">Inventory Name <span class="text-red-500">*</span></label>
                    <input name="editInventory" type="text" id="edit-inventory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product <span class="text-red-500">*</span></label>
                    <select name="editProduct" id="edit-product" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                        <option value="">Select Product</option>
                        @foreach ($product as $products)
                        <option value="{{ $products->productID }}">{{ $products->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Stock Level <span class="text-red-500">*</span></label>
                            <input min="0" name="editStockLevel" type="number" id="editStockLevel" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Minimum Stock Level <span class="text-red-500">*</span></label>
                            <input name="editMinLevel" type="number" id="editMinLevel" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeInventoryEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="editInventoryButton" name="addInventoryButton" value="Edit Inventory" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Update Inventory</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="inventoryAddModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Add Inventory</h2>
                <hr class="py-2">
                <form action="{{ route('addInventory.post') }}" method="POST">
                    @csrf
                    <label class="block text-gray-700 text-sm font-medium mt-4">Inventory Name <span class="text-red-500">*</span></label>
                    <input name="inventory" type="text" id="inventory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Product <span class="text-red-500">*</span></label>
                    <select name="product" id="product" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1 text-gray-700" required>
                        <option value="">Select Product</option>
                        @foreach ($product as $products)
                        <option value="{{ $products->productID }}">{{ $products->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex space-x-4 mt-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Stock Level <span class="text-red-500">*</span></label>
                            <input min="0" name="stockLevel" type="number" id="stockLevel" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-medium">Minimum Stock Level <span class="text-red-500">*</span></label>
                            <input name="minLevel" type="number" id="minLevel" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        </div>
                    </div>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeInventoryAddModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg mr-2">Close</button>
                        <button type="submit" id="addInventoryButton" name="addInventoryButton" value="Add Inventory" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Add Inventory</button>
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
    const modal = document.getElementById('userFilterModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeUserFilterModal() {
    const modal = document.getElementById('userFilterModal');
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

function openInventoryAddModal() {
    const modal = document.getElementById('inventoryAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeInventoryAddModal() {
    const modal = document.getElementById('inventoryAddModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}

function openInventoryEditModal(id, name, product, stockLevel, minLevel) {
    const modal = document.getElementById('inventoryEditModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    document.getElementById('inventoryID').value = id;
    document.getElementById('edit-inventory').value = name;
    document.getElementById('edit-product').value = product;
    document.getElementById('editStockLevel').value = stockLevel;
    document.getElementById('editMinLevel').value = minLevel;

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

function closeInventoryEditModal() {
    const modal = document.getElementById('inventoryEditModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        clearModalFields();
    }, 300);
}

function clearModalFields() {
    document.getElementById('registeredUserID').value = '';
    document.getElementById('firstName').value = '';
    document.getElementById('lastName').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phoneNo').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('dateOfBirth').value = '';
    document.getElementById('membershipStart').value = '';
    document.getElementById('membershipEnd').value = '';
}

function searchUsers() {
    const query = document.getElementById('searchInput').value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'searchUsers.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('userTableBody').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
</script>