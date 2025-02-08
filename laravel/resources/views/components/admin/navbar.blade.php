<main class="flex-1 ml-64">
    <header class="bg-[#CFCFCF] shadow p-4 mx-6 mt-5 rounded-3xl flex justify-between items-center">
        <div class="flex justify-end w-full items-center space-x-4 relative">
        @if (session('success'))
        <div id="toast-success" class="toast" role="alert">
            <div class="flex items-center w-full max-w-full p-4 mb-4 text-white rounded-lg shadow bg-indigo-500">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-indigo-500 bg-white rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div style="white-space: nowrap;" class="ms-2 px-2 text-base font-normal">{{ session('success') }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-indigo-500 text-white hover:text-indigo-600 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-indigo-600 inline-flex items-center justify-center h-8 w-8" aria-label="Close" onclick="removeToast()">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif
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
    <style>
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            z-index: 1000;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
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

        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-success');
            toast.classList.add('show');

            setTimeout(() => {
                removeToast();
            }, 3000);
        });

        function removeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }
    </script>
    <main>
        {{ $slot }}
    </main>