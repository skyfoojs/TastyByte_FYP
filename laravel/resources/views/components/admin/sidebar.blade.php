<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<aside class="w-64 bg-[#E8E8E8] h-full fixed">
    <div class="p-4">
        <a href="../../../views/admin/pages/index.php">
            <img src="{{ asset('images/' . 'TastyByte-Banner.png') }}" alt="Logo" class="w-48 mx-auto">
        </a>
    </div>

    <nav class="px-6 text-gray-700">
        <h2 class="text-gray-500 mt-2 mb-5 px-5 font-medium">Menu</h2>
        <ul class="space-y-4">
            <li>
                <!--Dashboard-->
                <a href="../admin/index.php"
                   class="flex items-center space-x-5 py-3 px-5 {{ $current_page == 'dashboard' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100' }} rounded-md">
                    <i class="bx bxs-dashboard text-base"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <!--Users-->
                <a href="../admin/users"
                   class="flex items-center space-x-5 py-3 px-5 {{ $current_page == 'users' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100' }} rounded-md">
                    <i class="bx bx-user text-base"></i>
                    <span class="font-medium">Users</span>
                </a>
            </li>
            <li>
                <!--Products-->
                <a href="../admin/products"
                   class="flex items-center space-x-5 py-3 px-5 {{ $current_page == 'products' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100' }} rounded-md">
                    <i class="bx bxs-package text-base"></i>
                    <span class="font-medium">Products</span>
                </a>
            </li>
            <li>
                <!--Nutritionists-->
                <a href="../admin/nutritionists.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'nutritionists.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-food-menu text-base"></i>
                    <span class="font-medium">Nutritionists</span>
                </a>
            </li>
            <li>
                <!--Instructors-->
                <a href="../admin/instructors.php"
                   class="flex items-center space-x-5 py-3 px-5 <?php echo $current_page == 'instructors.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-run text-base"></i>
                    <span class="font-medium">Instructors</span>
                </a>
            </li>
            <li>
                <!--Payments-->
                <a href="../admin/payments.php"
                   class="flex items-center space-x-6 py-3 px-5 <?php echo $current_page == 'payments.php' ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100'; ?> rounded-md">
                    <i class="bx bx-credit-card text-base"></i>
                    <span class="font-medium">Payments</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<main>
    {{ $slot }}
</main>