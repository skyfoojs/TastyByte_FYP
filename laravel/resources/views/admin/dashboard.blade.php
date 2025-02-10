<x-admin.layout>
    <x-admin.sidebar>
        <x-admin.navbar>
        <section class="p-6 space-y-6">
            <p class="text-3xl mx-4 font-bold">Dashboard</p>

            <div class="grid grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Users</h2>
                    <p class="text-3xl font-semibold mt-2">{{ $usersCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Products</h2>
                    <p class="text-3xl font-semibold mt-2">{{ $productsCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Inventory</h2>
                    <p class="text-3xl font-semibold mt-2">{{ $inventoriesCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl">
                    <h2 class="text-gray-600 font-medium">Vouchers</h2>
                    <p class="text-3xl font-semibold mt-2">{{ $vouchersCount }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Inventories Less Than 20</h2>
                        <a href="{{ route('admin-inventory') }}" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>

                    @if (empty($lowStock))
                        <p class="text-gray-500">Stock are all currently enough.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($lowStock as $lowStocks)
                                <li class="p-6 rounded-lg bg-violet-50">
                                    <p class="font-bold mb-2">Inventory ID: {{ $lowStocks->inventoryID }}</p>
                                    <p>Inventory Name: <span class="font-medium">{{ $lowStocks->name }}</span></p>
                                    <p>Stock Level: <span class="font-medium">{{ $lowStocks->stockLevel }}</span></p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-gray-600 font-bold">Upcoming Vouchers</h2>
                        <a href="../admin/nutritionists.php" class="text-sm text-indigo-500 font-medium hover:underline hover:text-indigo-600">view ></a>
                    </div>
                        <ul class="space-y-4">

                        </ul>
                </div>
            </div>
        </section>
        </x-admin.navbar>
    </x-admin.sidebar>
</x-admin.layout>