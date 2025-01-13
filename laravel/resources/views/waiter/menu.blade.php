<x-waiter.layout>
    <x-waiter.navbar>

    <div class="flex flex-col justify-center items-center">
        <p class="mt-6 font-semibold">Menu</p>

        <div class="grid grid-cols-2 gap-x-6 gap-y-7 mt-5">
            <a href="{{ route('table') }}" class="bg-[#DDD] px-10 pt-10 pb-7 rounded-lg flex flex-col justify-center items-center">
                <div class="bg-[#F0F0F0] p-10 rounded-lg"></div>
                <p class="mt-2">Order</p>
            </a>

            <div class="bg-[#DDD] px-10 pt-10 pb-7 rounded-lg flex flex-col justify-center items-center">
                <div class="bg-[#F0F0F0] p-10 rounded-lg"></div>
                <p class="mt-2">Track Order</p>
            </div>
        </div>
    </div>
    </x-waiter.navbar>
</x-waiter.layout>