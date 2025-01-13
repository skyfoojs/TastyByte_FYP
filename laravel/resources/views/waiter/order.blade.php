<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col">
            <x-waiter.table-header :table="session('tableNo')">
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
                            <a href="{{ url('/product-details/' . $product->productID) }}">
                            <div class="flex gap-x-10 items-center mt-4 ml-8">
                                <div class="w-28 h-28 bg-[#E1E1E1] rounded-lg"></div>
                                <div>
                                    <p>{{ $product->name }}</p>
                                    <p>{{ $product->price }}</p>
                                </div>
                            </div>
                            </a>
                            <hr class="mt-3">
                        @endforeach
                    </div>
                @endforeach
            </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>
