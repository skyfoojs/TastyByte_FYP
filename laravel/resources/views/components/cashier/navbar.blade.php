<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-26 items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12">
                <p class="text-gray-300 text-2xl font-bold">TastyByte</p>
            </div>

            <div class="hidden sm:ml-6 sm:block">
                <div class="flex space-x-6">
                    <a href="{{ route('cashier.dashboard') }}"
                       class="{{ request()->routeIs('cashier.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
          rounded-md px-5 py-4 text-lg font-bold">
                        Dashboard
                    </a>

                    <a href="{{ route('cashier.table') }}"
                       class="{{ request()->routeIs('cashier.table') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
          rounded-md px-5 py-4 text-lg font-bold"
                       aria-current="{{ request()->routeIs('cashier.table') ? 'page' : '' }}">
                        Order Food
                    </a>

                    <a href="{{ route('trackOrder') }}"
                       class="{{ request()->routeIs('trackOrder') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
          rounded-md px-5 py-4 text-lg font-bold"
                       aria-current="{{ request()->routeIs('trackOrder') ? 'page' : '' }}">
                        Order History
                    </a>

                    <a href="{{ route('cashier.inventory') }}"
                       class="{{ request()->routeIs('cashier.inventory') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}
          rounded-md px-5 py-4 text-lg font-bold"
                       aria-current="{{ request()->routeIs('cashier.inventory') ? 'page' : '' }}">
                        Check Inventory
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-2 mr-2">
                <button id="dropdownToggle" class="flex items-center space-x-2">
                    <span class="font-semibold text-gray-300 mr-3">{{ session('username') ?? 'Null' }}</span>
                    <img class="size-12 rounded-full"
                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                         alt="">
                </button>

                <div id="dropdownMenu" class="absolute right-0 mt-35 p-2 w-48 bg-white border border-gray-200 rounded-lg hidden">
                    <a href="{{ route('logout') }}"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bx-log-out text-base'></i>
                        <span class="font-medium">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('dropdownToggle').addEventListener('click', function () {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
        const toggleButton = document.getElementById('dropdownToggle');
        const dropdownMenu = document.getElementById('dropdownMenu');
        if (!toggleButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
<main>
    {{ $slot }}
</main>
