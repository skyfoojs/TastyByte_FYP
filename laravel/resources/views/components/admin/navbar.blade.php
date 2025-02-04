<main class="flex-1 ml-64">
    <header class="bg-[#CFCFCF] shadow p-4 mx-6 mt-5 rounded-3xl flex justify-between items-center">
        <div class="flex justify-end w-full items-center space-x-4 relative">
            <div class="relative">
                @if ($errors->any())
                    <div x-data="{ show: false }"
                        x-init="setTimeout(() => show = true, 300); setTimeout(() => show = false, 4000)"
                        x-show="show"
                        x-cloak
                        x-transition:enter="transition transform opacity ease-out duration-500"
                        x-transition:enter-start="translate-x-full opacity-0"
                        x-transition:enter-end="translate-x-0 opacity-100"
                        x-transition:leave="transition transform opacity ease-in duration-500"
                        x-transition:leave-start="translate-x-0 opacity-100"
                        x-transition:leave-end="translate-x-full opacity-0"
                        class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-md">
                        <strong>Error:</strong>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button id="dropdownToggle" class="flex items-center space-x-2 mr-2">
                    <!--Show username according the login username-->
                    <span class="font-semibold text-gray-700 mr-3">{{ session('username') ?? 'Admin' }}</span>
                    <img src="../../public/images/avatar.png" alt="Admin Avatar" class="w-10 h-10 rounded-full">
                </button>

                <div id="dropdownMenu" class="absolute right-0 mt-2 p-2 w-48 bg-white border border-gray-200 rounded-lg hidden">
                    <!--Admin Profile Page-->
                    <a href="../admin/profile.php"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bxs-user text-base'></i>
                        <span class="font-medium">View Profile</span>
                    </a>
                    <!--Log Out Function-->
                    <a href="../logout.php"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bx-log-out text-base'></i>
                        <span class="font-medium">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

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