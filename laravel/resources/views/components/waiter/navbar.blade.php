<nav class="bg-gray-800 z-10">
    <header class="p-4 py-6 mx-6 rounded-3xl flex justify-between items-center">
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
        <div class="flex justify-between w-full items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12">
                <p class="text-gray-300 text-2xl font-bold">TastyByte</p>
            </div>

            <div class="relative flex items-center">
                <button id="dropdownToggle" class="flex items-center">
                    <span class="text-gray-300 font-semibold mr-3">{{ session('username') ?? 'Waiter' }}</span>
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                         alt="Waiter Avatar" class="w-10 h-10 rounded-full bg-white">
                </button>

                <div id="dropdownMenu" class="z-50 absolute right-0 mt-2 p-2 w-48 bg-white border border-gray-200 rounded-lg hidden">
                    <a href="{{ route('logout') }}"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bx-log-out text-base'></i>
                        <span class="font-medium">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
</nav>

<main>
{{ $slot }}
</main>
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
