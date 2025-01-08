<x-layout>
    <nav class="bg-light-gray">
    <header class="p-4 mx-6 rounded-3xl flex justify-between items-center">
        <div class="flex justify-end w-full items-center relative">
            <div class="relative">
                <button id="dropdownToggle" class="flex items-center">
                    <img src="#" alt="Admin Avatar" class="w-10 h-10 rounded-full bg-white">
                </button>

                <div id="dropdownMenu" class="absolute right-0 mt-2 p-2 w-48 bg-white border border-gray-200 rounded-lg hidden">
                    <a href="#"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bxs-user text-base'></i>
                        <span class="font-medium"></span>
                    </a>

                    <a href="#"
                       class="flex items-center space-x-5 py-3 px-5 hover:bg-gray-100 rounded-md">
                        <i class='bx bx-log-out text-base'></i>
                        <span class="font-medium"></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    </nav>

    <div class="flex flex-col justify-center items-center">
        <p class="mt-6 font-semibold">Menu</p>

        <div class="grid grid-cols-2 gap-x-6 gap-y-7 mt-5">
            @foreach ($products as $product)
            <div class="bg-[#DDD] px-10 pt-10 pb-7 rounded-lg flex flex-col justify-center items-center">
                <div class="bg-[#F0F0F0] p-10 rounded-lg"></div>

                <p class="mt-2">{{ $product->name }}</p>
                <p>{{ $product->price }}</p>
            </div>
            @endforeach
        </div>
    </div>
</x-layout>


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
