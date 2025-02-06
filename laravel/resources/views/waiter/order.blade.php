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
                                @if ($product->status == 'Not Available')
                                    <!-- If product is not available, show an error message and disable the link -->
                                    <div class="flex gap-x-10 items-center py-4 pl-8 bg-gray-400 opacity-70">
                                        <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                            @if (!empty($product->image))
                                                <img class="w-full" src="{{ asset($product->image) }}" alt="Image Not Available">
                                            @else
                                                <p class="text-white">No Image</p>
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <p>{{ $product->name }}</p>
                                            <p>{{ $product->price }}</p>
                                            <p class="text-red-500 text-sm">Product not available</p> <!-- Error message -->
                                        </div>
                                    </div>
                                    <hr>
                                @else
                                    <!-- If product is available, make it clickable -->
                                    <a href="{{ url('/product-details/' . $product->productID) }}">
                                        <div class="flex gap-x-10 items-center py-4 pl-8">
                                            <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                                @if (!empty($product->image))
                                                    <img class="w-full" src="{{ asset($product->image) }}" alt="Image Not Available">
                                                @else
                                                    <p>No Image</p>
                                                @endif
                                            </div>
                                            <div>
                                                <p>{{ $product->name }}</p>
                                                <p>{{ $product->price }}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>
