<x-kitchen.layout>
    <x-kitchen.navbar>
        <div class="flex h-screen relative">
            <div class="w-full p-6 mt-25">
                <div class="flex items-center mt-2">
                    <a href="{{ route('kitchen.index', ['filter' => 'pending']) }}"
                       class="p-3 mr-4 {{ request('filter', 'pending') === 'pending' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        Pending
                    </a>
                    <a href="{{ route('kitchen.index', ['filter' => 'completed']) }}"
                       class="p-3 mr-4 {{ request('filter') === 'completed' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        Completed
                    </a>
                    <a href="{{ route('kitchen.index', ['filter' => 'all']) }}"
                       class="p-3 {{ request('filter') === 'all' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        All
                    </a>
                </div>

                <div class="mt-6">
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="orderList"></div>
                </div>
            </div>
        </div>
    </x-kitchen.navbar>
</x-kitchen.layout>
<script>
async function fetchOrderItems() {
    try {
        // Get the current filter from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'pending'; // Default to 'pending' if no filter is provided

        const response = await fetch(`{{ route('kitchen.order-items') }}?filter=${filter}`);
        const data = await response.json();

        let orderList = document.getElementById("orderList");
        orderList.innerHTML = "";

        // Filter order items based on the selected filter
        let filteredOrders = data.orderItems.filter(item => {
            if (filter === 'all') return true;
            return item.status.toLowerCase() === filter.toLowerCase();
        });

        if (filteredOrders.length === 0) {
            orderList.innerHTML = `<p class="text-center text-gray-500 text-lg font-semibold mt-10">No ${filter} orders</p>`;
        } else {
            filteredOrders.forEach(item => {
                console.log(item.status)
                // Parse the remark JSON
                let remarkData = item.remark ? JSON.parse(item.remark) : {};
                let takeaway = remarkData.takeaway ? "Takeaway" : "Dine In";

                // Extract options
                let remarkOptions = [];
                if (remarkData.options) {
                    for (const values of Object.values(remarkData.options)) {
                        remarkOptions.push(values.join(", "));
                    }
                }
                let formattedRemarks = remarkOptions.length > 0 ? remarkOptions.join("<br>") : "-";

                orderList.innerHTML += `
                <div class="bg-white p-4 shadow rounded-lg">
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-gray-700 font-bold">${takeaway}</p>
                        <div class="flex items-center space-x-2">
                            <p class="${item.status === 'Pending' ? 'text-red-500 bg-red-100 px-4 py-2 text-sm rounded-full' : 'text-green-500 bg-green-100 px-4 py-2 text-sm rounded-full'} font-bold">
                                ${item.status}
                            </p>
                            <p class="text-white bg-indigo-500 px-3 py-1 rounded-full">${item.quantity}</p>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <p class="text-gray-700"><strong>Order ID:</strong> ${item.orderID}</p>
                    <p class="text-gray-700"><strong>Table No:</strong> ${item.orders ? item.orders.tableNo : '-'}</p>
                    <p class="text-gray-700"><strong>Product:</strong> ${item.products ? item.products.name : '-'}</p>
                    <p class="text-gray-700"><strong>Remark:</strong><br> ${formattedRemarks}</p>
                </div>
                `;
            });
        }
    } catch (error) {
        console.error("Error fetching order items", error);
    }
}

// Refresh every 5 seconds
setInterval(fetchOrderItems, 5000);

// Initial fetch
fetchOrderItems();

</script>