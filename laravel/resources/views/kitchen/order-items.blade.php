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
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="orderList"></div>
                </div>
            </div>
        </div>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

        <div id="orderCompleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50 modal">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 mx-4 modal-content">
                <h2 class="text-2xl font-semibold mb-4">Update Order Items</h2>
                <hr class="py-2">
                <p class="text-gray-700">Do you want to mark this order as completed?</p>
                <div class="flex justify-end mt-10">
                    <button type="button" onclick="closeOrderCompleteModal()"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg mr-2">
                        取消
                    </button>
                    <button type="button" onclick="confirmOrderCompletion()"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg">
                        确认
                    </button>
                </div>
            </div>
        </div>
    </x-kitchen.navbar>
</x-kitchen.layout>

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
    if(window.innerWidth < 768) {
        window.location.href = "{{ url('/404') }}";
    }
    let selectedOrderItemID = null;

    function openOrderCompleteModal(orderItemID) {
        console.log("Order Item ID: ", orderItemID);
        selectedOrderItemID = orderItemID;

        document.getElementById('orderCompleteModal').classList.remove('hidden');
        document.getElementById('modalOverlay').classList.remove('hidden');

        setTimeout(() => {
            document.getElementById('orderCompleteModal').classList.add('show');
        }, 10);
    }

    function closeOrderCompleteModal() {
        const modal = document.getElementById('orderCompleteModal');
        modal.classList.remove('show');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('modalOverlay').classList.add('hidden');
        }, 300);
    }

    async function confirmOrderCompletion() {
        if (!selectedOrderItemID) {
            alert("Empty Order Item ID");
            return;
        }

        try {
            const response = await fetch("{{ route('updateOrderItemStatus') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ orderItemID: selectedOrderItemID })
            });

            const result = await response.json();
            console.log("Response:", result);

            if (result.success) {
                closeOrderCompleteModal();
                fetchOrderItems();
            } else {
                alert("Error：" + result.message);
            }
        } catch (error) {
            console.error("Update error:", error);
        }
    }

    async function fetchOrderItems() {
        try {
            const urlParams = new URLSearchParams(window.location.search);
            const filter = urlParams.get('filter') || 'pending';

            const response = await fetch(`{{ route('kitchen.order-items') }}?filter=${filter}`);
            const data = await response.json();

            let orderList = document.getElementById("orderList");
            orderList.innerHTML = "";

            let filteredOrders = data.orderItems.filter(item => {
                if (filter === 'all') return true;
                return item.status.toLowerCase() === filter.toLowerCase();
            });

            if (filteredOrders.length === 0) {
                orderList.innerHTML = `<p class="text-center text-gray-500 text-lg font-semibold mt-10">No ${filter} orders</p>`;
            } else {
                filteredOrders.forEach(item => {
                    let remarkData = item.remark ? JSON.parse(item.remark) : {};
                    let isTakeaway = remarkData.takeaway;
                    let takeawayText = isTakeaway ? "Takeaway" : "Dine In";
                    let takeawayColor = isTakeaway ? "text-red-500" : "text-indigo-500";
                    let formattedRemarks = remarkData.options ? Object.values(remarkData.options).flat().join(", ") : "-";

                    orderList.innerHTML += `
                    <div onclick="openOrderCompleteModal('${item.orderItemID}')" class="cursor-pointer bg-white p-4 shadow rounded-lg hover:shadow-lg transition">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-gray-700 font-bold">${takeawayText}</p>
                            <div class="flex items-center space-x-2">
                                    <p class="${item.status === 'Pending' ? 'text-red-500 bg-red-100 px-4 py-2 text-sm rounded-full' : 'text-green-500 bg-green-100 px-4 py-2 text-sm rounded-full'} font-bold">
                                        ${item.status}
                                    </p>
                                </div>
                            </div>
                        <hr class="mb-2">
                        <p class="text-gray-700"><strong>Order ID:</strong> ${item.orderID}</p>
                        <p class="text-gray-700"><strong>Table No:</strong> ${item.orders?.tableNo || '-'}</p>
                        <p class="text-gray-700"><strong>Order Item:</strong> ${item.products?.name || '-'}</p>
                        <p class="text-gray-700"><strong>Quantity:</strong> ${item.quantity || '-'}</p>
                        <p class="text-gray-700"><strong>Remark:</strong> ${formattedRemarks || '-'}</p>
                    </div>
                `;
                });
            }
        } catch (error) {
            console.error("Error when fetching order items: ", error);
        }
    }

    setInterval(fetchOrderItems, 5000);
    fetchOrderItems();
</script>
