<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <p class="text-3xl mx-4 font-bold">Dashboard</p>

            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Users</h2>
                    <p id="usersCount" class="text-3xl font-semibold mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Products</h2>
                    <p id="productsCount" class="text-3xl font-semibold mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Inventory</h2>
                    <p id="inventoriesCount" class="text-3xl font-semibold mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Vouchers</h2>
                    <p id="vouchersCount" class="text-3xl font-semibold mt-2">0</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Inventories Less Than 20</h2>
                        <a href="{{ route('admin-inventory') }}" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>
                    <ul id="lowStockList" class="space-y-4"></ul>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Upcoming Vouchers</h2>
                        <a href="{{ route('admin-vouchers') }}" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>
                    <ul id="upcomingVoucherList" class="space-y-4"></ul>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-gray-600 font-bold">Latest Transaction Records</h2>
                    <a href="" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                </div>

                <div class="flex flex-col space-y-2">
                    <ul class="space-y-4">
                        <li class="p-4 rounded-lg bg-red-50">
                            <p class="font-semibold mb-2">Payment ID #<span class="font-medium"></span></p>
                            <p>Type: <span class="font-medium"></span></p>
                            <p>Status: <span class="font-medium"></span></p>
                            <p>Date: <span class="font-medium"></span></p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>
<script>
    async function fetchDashboardData() {
        try {
            const response = await fetch("{{ route(name: 'dashboard-data') }}");
            const data = await response.json();

            // Update counts dynamically
            document.getElementById("usersCount").textContent = data.usersCount;
            document.getElementById("productsCount").textContent = data.productsCount;
            document.getElementById("inventoriesCount").textContent = data.inventoriesCount;
            document.getElementById("vouchersCount").textContent = data.vouchersCount;

            // Update low stock inventory list
            let lowStockList = document.getElementById("lowStockList");
            lowStockList.innerHTML = ""; // Clear previous items

            if (data.lowStock.length === 0) {
                lowStockList.innerHTML = `<p class="text-gray-500">Stock is all currently enough.</p>`;
            } else {
                data.lowStock.forEach(item => {
                    lowStockList.innerHTML += `
                        <li class="p-6 rounded-lg bg-violet-50">
                            <p class="font-bold mb-2">Inventory ID: ${item.inventoryID}</p>
                            <p>Inventory Name: <span class="font-medium">${item.name}</span></p>
                            <p>Stock Level: <span class="font-medium">${item.stockLevel}</span></p>
                        </li>
                    `;
                });
            }

            let upcomingVoucherList = document.getElementById("upcomingVoucherList");
            upcomingVoucherList.innerHTML = "";

            if (data.upcomingVouchers.length === 0) {
                upcomingVouchers.innerHTML = `<p class="text-gray-500">No Upcoming Vouchers.</p>`;
            } else {
                data.upcomingVouchers.forEach(item => {
                    upcomingVoucherList.innerHTML += `
                        <li class="p-6 rounded-lg bg-violet-50">
                            <p class="font-bold mb-2">Voucher ID: ${item.voucherID}</p>
                            <p>Voucher Code: <span class="font-medium">${item.code}</span></p>
                            <p>Start Date: <span class="font-medium">${item.startedOn}</span></p>
                        </li>
                    `;
                });
            }
        } catch (error) {
            console.error("Error fetching dashboard data:", error);
        }
    }

    // Fetch data every 5 seconds (real-time updates)
    setInterval(fetchDashboardData, 5000);

    // Initial fetch
    fetchDashboardData();
</script>
