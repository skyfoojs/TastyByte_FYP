@section('title', 'Track Inventory - TastyByte')

<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen relative">
            <div class="w-full p-6 mt-25">
                <div class="flex items-center mb-6 space-x-4">
                    <button onclick="openInventoryAddModal()" class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium py-3 px-8 rounded-xl flex items-center space-x-1">
                        <i class='bx bx-plus-circle'></i>
                        <span>Add Inventory</span>
                    </button>

                    <button onclick="openFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-8 rounded-xl flex items-center space-x-1">
                        <i class='bx bx-filter-alt'></i>
                        <span>Filter</span>
                    </button>
                </div>
                <div class="mt-6">
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="inventoryList"></div>
                </div>
            </div>
        </div>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="inventoryFilterModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4">
                <h2 class="text-2xl font-semibold mb-4">Filter Inventory</h2>
                <hr class="py-2">
                <form action="{{ route('cashier.inventory') }}" method="GET">
                <label class="block text-gray-700 text-sm font-medium">Filter By <span class="text-red-500">*</span></label>
                    <select name="filterType" id="filterType" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>
                        <option value="">Please Select a Type</option>
                        <option value="filterInventoryID">Inventory ID</option>
                        <option value="filterCategoryName">Category Name</option>
                        <option value="filterStockMoreThan">Stock More Than</option>
                        <option value="filterStockLessThan">Stock Less Than</option>
                    </select>

                    <label class="block text-gray-700 text-sm font-medium mt-4">Keyword <span class="text-red-500">*</span></label>
                    <input name="keywords" type="text" id="scheduleKeywords" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

                    <div class="flex justify-end mt-10">
                        <button type="button" onclick="closeFilterModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">Close</button>
                        <a href="{{ route('cashier.inventory') }}" class="text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-6 rounded-lg mr-2">Reset</a>
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="inventoryEditModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Edit Inventory</h2>
                <hr class="py-2">
                <form action="{{ route('cashierEditInventory.post') }}" method="POST">
                    <input type="hidden" id="inventoryID" name="inventoryID">
                    @csrf
                    @method('PUT')
                    <label class="block text-gray-700 text-sm font-medium mt-4">Inventory Name <span class="text-red-500">*</span></label>
                    <input name="editInventory" type="text" id="edit-inventory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

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
                <form action="{{ route('cashierAddInventory.post') }}" method="POST">
                    @csrf
                    <label class="block text-gray-700 text-sm font-medium mt-4">Inventory Name <span class="text-red-500">*</span></label>
                    <input name="inventory" type="text" id="inventory" class="w-full border border-gray-300 rounded-lg py-2 px-3 mt-1" required>

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
    </x-cashier.navbar>
</x-cashier.layout>

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
        const modal = document.getElementById('inventoryFilterModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }

    function closeFilterModal() {
        const modal = document.getElementById('inventoryFilterModal');
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

    function openInventoryEditModal(id, name, stockLevel, minLevel) {
        const modal = document.getElementById('inventoryEditModal');
        const overlay = document.getElementById('modalOverlay');

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');

        document.getElementById('inventoryID').value = id;
        document.getElementById('edit-inventory').value = name;
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
        document.getElementById('inventoryID').value = '';
        document.getElementById('edit-inventory').value = '';
        document.getElementById('editStockLevel').value = '';
        document.getElementById('editMinLevel').value = '';
    }

    async function fetchInventory() {
        try {
            const response = await fetch("{{ route('cashier.inventory') }}", {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await response.json();

            let inventoryList = document.getElementById("inventoryList");
            inventoryList.innerHTML = "";

            if (data.inventory.length === 0) {
                inventoryList.innerHTML = `<p class="text-center text-gray-500 text-lg font-semibold mt-10">No inventory items found</p>`;
            } else {
                data.inventory.forEach(item => {
                    let stockStatusClass = item.stockLevel <= item.minLevel ? "text-red-500 bg-red-100" : "text-green-500 bg-green-100";

                    inventoryList.innerHTML +=
                        `<div onclick="openInventoryEditModal('${item.inventoryID}', '${item.name}', ${item.stockLevel}, ${item.minLevel})" class="cursor-pointer bg-white p-4 shadow rounded-lg hover:shadow-lg transition">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-gray-700 font-bold">${item.name}</p>
                            <p class="${stockStatusClass} px-3 py-2 text-sm rounded-full font-bold">
                                ${item.stockLevel}
                            </p>
                        </div>
                        <hr class="mb-2">
                        <p class="text-gray-700"><strong>Inventory ID:</strong> ${item.inventoryID}</p>
                        <p class="text-gray-700"><strong>Minimum Level:</strong> ${item.minLevel}</p>
                    </div>`;
                });
            }
        } catch (error) {
            console.error("Error fetching inventory", error);
        }
    }

    fetchInventory();

    // Refresh every 10 seconds
    setInterval(fetchInventory, 10000);

    // Initial fetch
    fetchInventory();
</script>
