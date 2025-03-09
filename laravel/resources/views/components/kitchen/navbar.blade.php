<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-26 items-center justify-between">
            <a href="{{ route('kitchen.index') }}" class="flex items-center space-x-4">
                <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12">
                <p class="text-gray-300 text-2xl font-bold">TastyByte</p>
            </a>

            <div class="flex items-center space-x-2 mr-2">
                <button id="dropdownToggle" class="flex items-center space-x-2">
                    <span class="font-semibold text-gray-300 mr-3">{{ session('username') ?? 'Null' }}</span>
                    <img class="size-12 rounded-full"
                         src="{{ asset('images/' . 'avatar.png') }}"
                         alt="avatar">
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
