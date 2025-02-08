<x-waiter.layout>
    <x-waiter.navbar>

    <div class="flex flex-col justify-center items-center px-2">
        <p class="mt-6 font-semibold">Menu</p>

        <div class="grid grid-cols-2 gap-x-4 gap-y-7 mt-5">
            <a href="{{ route('table') }}" class="bg-[#DDD] px-10 pt-10 pb-7 rounded-lg flex flex-col justify-center items-center">
                <div class="bg-[#F0F0F0] p-2 rounded-lg">
                    <img class="" src="{{ asset('images/' . 'menu-order.png') }}" alt="">
                </div>
                <p class="mt-2">Order</p>
            </a>

            <a href="{{ route('trackOrder') }}" class="bg-[#DDD] px-10 pt-10 pb-7 rounded-lg flex flex-col justify-center items-center">
                <div class="bg-[#F0F0F0] p-2 rounded-lg">
                    <img class="" src="{{ asset('images/' . 'menu-track-order.png') }}" alt="">
                </div>
                <p class="mt-2">Track Order</p>
            </a>
        </div>
    </div>
    </x-waiter.navbar>
</x-waiter.layout>