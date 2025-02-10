<?php
$current_route = Route::currentRouteName();
$is_users_page = Str::contains($current_route, 'users'); // Check if the route contains 'users'
?>

<aside class="w-64 bg-gray-800 h-full fixed">
    <div class="p-4">
        <a href="{{ url('admin') }}">
            <img src="{{ asset('images/' . 'TastyByte-Banner.png') }}" alt="Logo" class="w-48 mx-auto">
        </a>
    </div>

    <nav class="px-6 text-gray-300">
        <h2 class="mt-2 mb-5 px-5 font-medium">Menu</h2>
        <ul class="space-y-4">
            <li>
                <!-- Dashboard -->
                <a href=""
                   class="hover:text-white flex items-center space-x-5 py-3 px-5 {{ $current_route == 'admin.dashboard' ? 'bg-gray-900 text-white' : 'hover:bg-gray-700' }} rounded-md">
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
        </ul>
    </nav>
</aside>

<main>
    {{ $slot }}
</main>
