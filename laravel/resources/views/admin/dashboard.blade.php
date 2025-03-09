@section('title', 'Admin Dashboard - TastyByte')

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
                        <h2 class="text-gray-600 font-bold">Inventories Less Than 10</h2>
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
                    <h2 class="text-gray-600 font-bold">Latest Payment Records</h2>
                    <a href="{{ route('admin-payments') }}" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                </div>

                <div class="flex flex-col space-y-2">
                    <ul id="latestPaymentList" class="space-y-4"></ul>
                </div>
            </div>
        </section>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>
<script>
    if(window.innerWidth < 768) {
        window.location.href = "{{ url('/404') }}";
    }

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
                upcomingVoucherList.innerHTML = `<p class="text-gray-500">No Upcoming Vouchers.</p>`;
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

            let latestPaymentList = document.getElementById("latestPaymentList");
            latestPaymentList.innerHTML = "";

            if(data.payments.length === 0) {
                latestPaymentList.innerHTML = `<p class="text-gray-500">No Payment Record.</p>`;
            } else {
                data.payments.forEach(item => {
                    const date = new Date(item.updated_at);
                    const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`;

                    latestPaymentList.innerHTML += `
                    <li class="p-6 rounded-lg bg-violet-50">
                        <p class="font-semibold mb-2">Payment ID #<span class="font-medium">${item.paymentID}</span></p>
                        <p>Order ID: <span class="font-medium">${item.orderID}</span></p>
                        <p>Voucher ID: <span class="font-medium">${item.voucherID ?? 'No Voucher Applied'}</span></p>
                        <p>Total Amount: <span class="font-medium">RM ${parseFloat(item.totalAmount).toFixed(2)}</span></p>
                        <p>Payment Method: <span class="font-medium">${item.paymentMethod}</span></p>
                        <p>Payment Status: <span class="font-medium">${item.status}</span></p>
                        <p>Payment Date: <span class="font-medium">${formattedDate}</span></p>
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
