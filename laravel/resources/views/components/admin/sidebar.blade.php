<?php
$current_route = Route::currentRouteName();
$is_users_page = Str::contains($current_route, 'users'); // Check if the route contains 'users'
?>

<aside class="w-64 bg-gray-800 h-full fixed">
    <div class="flex justify-center items-center mt-12">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12">
            <p class="text-gray-300 text-2xl font-bold">TastyByte</p>
        </div>
    </div>

    <nav class="px-6 text-gray-300 mt-10">
        <h2 class="mt-2 px-5 font-medium">Menu</h2>
        <ul class="space-y-4 mt-8">
            <li>
                <!-- Dashboard -->
                <a href="{{ route('admin-dashboard') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin-dashboard' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bx bxs-dashboard text-base"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <!-- Users -->
                <a href="{{ route('admin-users') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $is_users_page ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bi bi-people-fill"></i>
                    <span class="font-medium">Users</span>
                </a>
            </li>
            <li>
                <!-- Products -->
                <a href="{{ route('admin-products') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin-products' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bx bxs-package text-base"></i>
                    <span class="font-medium">Products</span>
                </a>
            </li>
            <li>
                <!-- Inventory -->
                <a href="{{ route('admin-inventory') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin-inventory' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bi bi-kanban"></i>
                    <span class="font-medium">Inventory</span>
                </a>
            </li>
            <li>
                <!-- Vouchers -->
                <a href="{{ route('admin-vouchers') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin-vouchers' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bi bi-ticket-detailed-fill"></i>
                    <span class="font-medium">Vouchers</span>
                </a>
            </li>
            <li>
                <!-- Payments -->
                <a href="{{ route('admin-payments') }}"
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin-payments' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
                    <i class="bi bi-credit-card-fill"></i>
                    <span class="font-medium">Payments</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

<main>
    {{ $slot }}
</main>
