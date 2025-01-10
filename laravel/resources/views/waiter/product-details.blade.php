<x-layout>
    <x-navbar>
        <x-table-header>

        <div class="flex flex-col justify-center items-center px-7">
            <div class="w-full bg-[#E1E1E1] h-56 mt-7 rounded-lg"></div>

            <div class="flex flex-col mt-6 w-full">
                <div class="flex justify-between text-xl font-bold">
                    <p>{{ $productDetails->name }}</p>
                    <p class="text-red-700">{{ 'RM ' . $productDetails->price }}</p>
                </div>

                <div>
                    <p class="mt-4 text-lg">Description:</p>
                    <p>{{ $productDetails->description }}</p>
                </div>

                <form action="">
                    <div class="flex bg-[#EEEEEE] items-center mt-4 justify-between px-8 py-4 rounded-lg">
                        <label class="font-bold" for="takeaway">Takeaway</label>
                        <input class="w-4 h-4" type="radio" value="takeaway">
                    </div>
                </form>
            </div>
        </div>
        </x-table-header>
    </x-navbar>
</x-layout>