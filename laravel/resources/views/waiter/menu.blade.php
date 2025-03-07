<x-waiter.layout>
    <x-waiter.navbar>

    <div class="flex flex-col justify-center items-center px-2 mt-24">
        <p class="mt-6 font-semibold text-xl">Waiter Menu</p>

        <div class="grid grid-cols-2 gap-x-4 gap-y-4 mt-5 p-2">
            <a href="{{ route('table') }}" class="bg-white p-10 rounded-xl shadow shadow-indigo-200 flex flex-col justify-center items-center">
                <div class="p-2 rounded-lg">
                    <i class="bx bx-shopping-bag text-6xl text-gray-600"></i>
                </div>
                <p class="mt-4 font-bold text-center text-lg text-gray-600">Order Food</p>
            </a>

            <a href="{{ route('trackOrder') }}" class="bg-white p-10 rounded-xl shadow shadow-indigo-200 flex flex-col justify-center items-center">
                <div class="p-2 rounded-lg">
                    <i class="bx bx-time text-6xl text-gray-600"></i>
                </div>
                <p class="mt-4 font-bold text-center text-lg text-gray-600">Track Order</p>
            </a>
        </div>
    </div>
    </x-waiter.navbar>
</x-waiter.layout>
