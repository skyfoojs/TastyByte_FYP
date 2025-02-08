<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen">
            <div class="w-3/4 p-6 mt-25">
                <!-- Select and search bar -->
                <div class="flex items-center space-x-4 mb-6">
                    <select class="p-2 bg-white px-10 rounded-full">
                        <option>All Categories</option>
                        <option>Food</option>
                        <option>Beverages</option>
                        <option>Desserts</option>
                    </select>
                    <input type="text" placeholder="Search ..." class="p-2 bg-white rounded-full w-1/3 ps-4">
                </div>

                <!-- Food Items -->
                <div class="overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                        <img src="currymee.jpg" alt="Curry Mee" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">Curry Mee</h3>
                            <p class="text-gray-600 text-sm mb-4">Made by Chef Sky</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-slate-800 font-semibold">RM 10.00</span>
                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                    <span class="mx-4">1</span>
                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                        <img src="currymee.jpg" alt="Curry Mee" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">Curry Mee</h3>
                            <p class="text-gray-600 text-sm mb-4">Made by Chef Sky</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-slate-800 font-semibold">RM 10.00</span>
                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                    <span class="mx-4">1</span>
                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                        <img src="currymee.jpg" alt="Curry Mee" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">Curry Mee</h3>
                            <p class="text-gray-600 text-sm mb-4">Made by Chef Sky</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-slate-800 font-semibold">RM 10.00</span>
                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                    <span class="mx-4">1</span>
                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                        <img src="currymee.jpg" alt="Curry Mee" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">Curry Mee</h3>
                            <p class="text-gray-600 text-sm mb-4">Made by Chef Sky</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-slate-800 font-semibold">RM 10.00</span>
                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                    <span class="mx-4">1</span>
                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                        <img src="currymee.jpg" alt="Curry Mee" class="w-full h-60 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2">Curry Mee</h3>
                            <p class="text-gray-600 text-sm mb-4">Made by Chef Sky</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-slate-800 font-semibold">RM 10.00</span>
                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                    <span class="mx-4">1</span>
                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <x-cashier.sidebar>

                    </x-cashier.sidebar>
    </x-cashier.navbar>
</x-cashier.layout>
