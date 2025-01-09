<x-layout>
    <x-navbar>
        <div class="flex flex-col">
            <div class="flex w-full mt-4 items-center justify-center relative">
                <i class='bx bx-chevron-left bx-md absolute left-3'></i>
                <div class="text-lg font-semibold">Table 2</div>
            </div>

            <div class="flex justify-center items-center mt-4">
                <select class="w-72 rounded-2xl py-1 px-4 bg-[#E6E6E6] border-r-[12px]" name="" id="">
                    <option value="">Test</option>
                </select>
                <i class='bx bx-search ml-5 bx-sm text-[#8E8E8E]'></i>
            </div>

            <div class="flex flex-col">
                @foreach ($groupedProducts as $categoryName => $products)
                    <!-- Display Category Name -->
                    <div class="mt-6 mb-2">
                        <p class="ml-8 bg-[#4E4E4E] w-28 rounded-xl text-white text-center py-1">{{ $categoryName }}</p>
                        <hr class="mt-3">

                        <!-- Loop through products under the category -->
                        @foreach ($products as $product)
                            <div class="flex gap-x-10 items-center mt-4 ml-8">
                                <div class="w-28 h-28 bg-[#E1E1E1] rounded-lg"></div>
                                <div>
                                    <p>{{ $product->name }}</p>
                                    <p>{{ $product->price }}</p>
                                </div>
                            </div>
                            <hr class="mt-3">
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </x-navbar>
</x-layout>
