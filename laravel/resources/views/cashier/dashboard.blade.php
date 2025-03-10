@section('title', 'Cashier Dashboard - TastyByte')

<div class="bg-slate-200 text-3xl font-bold flex items-center justify-center h-screen md:hidden">
    <p>404</p>
</div>

<div class="hidden md:block">
    <x-cashier.layout>
        <x-cashier.navbar>
            <div class="flex h-screen relative">
                <div class="w-full p-6 mt-25">
                    <div class="grid grid-cols-4 gap-6">
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Today Total Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['todayOrderCount'] }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Today Total Amount</h2>
                            <p class="text-3xl font-semibold mt-2">{{ number_format($data['todayAmountCount'], 2) }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Today Pending Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['todayPendingCount'] }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Today Completed Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['todayCompleteCount'] }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Total Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['totalOrderCount'] }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Total Amount</h2>
                            <p class="text-3xl font-semibold mt-2">{{ number_format($data['totalAmountCount'], 2) }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Total Pending Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['totalPendingCount'] }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <h2 class="text-gray-600 font-medium">Total Completed Order</h2>
                            <p class="text-3xl font-semibold mt-2">{{ $data['totalCompletedCount'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-cashier.navbar>
    </x-cashier.layout>
</div>