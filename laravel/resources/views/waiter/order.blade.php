<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col">
            <x-waiter.table-header :table="'Table ' . session('tableNo')" :trackOrder="''">
                <div class="flex justify-center items-center mt-4">
                    <select class="w-72 rounded-2xl py-1 px-4 bg-white" name="categoryFilter" id="categoryFilter">
                        <option value="all">All Categories</option>
                        @foreach ($groupedProducts as $categoryName => $products)
                            <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col" id="productList">
                    @foreach ($groupedProducts as $categoryName => $products)
                        <div class="category-group" data-category="{{ $categoryName }}">
                            <div class="mt-6 mb-2">
                                <p class="text-l ml-8 bg-text-primary w-28 rounded-xl text-white text-center py-1">{{ $categoryName }}</p>
                                <hr class="mt-3">

                                @foreach ($products as $product)
                                    @if ($product->status == 'Not Available')
                                        <div class="flex gap-x-10 items-center py-4 pl-8 bg-gray-400 opacity-70">
                                            <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                                @if (!empty($product->image))
                                                    <img class="w-full h-full rounded-lg object-cover" src="{{ asset($product->image) }}" alt="Image Not Available">
                                                @else
                                                    <p class="text-white">No Image</p>
                                                @endif
                                            </div>
                                            <div class="text-white">
                                                <p>{{ $product->name }}</p>
                                                <p>{{ $product->price }}</p>
                                                <p class="text-red-500 text-sm">Product not available</p>
                                            </div>
                                        </div>
                                        <hr>
                                    @else
                                        <a href="{{ url('/product-details/' . $product->productID) }}">
                                            <div class="flex gap-x-10 items-center py-4 pl-8">
                                                <div class="border w-28 h-28 rounded-lg flex items-center justify-center">
                                                    @if (!empty($product->image))
                                                        <img class="w-full h-full rounded-lg object-cover" src="{{ asset($product->image) }}" alt="Image Not Available">
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @if(session('cart'))
                        <div class="w-full bg-[#F3F3F3] p-6 sticky bottom-0">
                            <div class="bg-blue-button rounded-lg text-white flex items-center justify-center py-4 gap-x-2">
                                <i class='bx bx-cart'></i>
                                <a href="{{ route('orderSummary') }}">
                                    Total Items:
                                    {{ array_reduce(session('cart'), function($carry, $item) {
                                        return $carry + $item['quantity'];
                                    }, 0) }} -
                                    RM {{ number_format(array_reduce(session('cart'), function($carry, $item) {
                                        return $carry + ($item['price'] * $item['quantity']);
                                    }, 0), 2) }} - Checkout
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>

<script>
    document.getElementById('categoryFilter').addEventListener('change', function() {
        let selectedCategory = this.value;
        let categories = document.querySelectorAll('.category-group');

        categories.forEach(category => {
            if (selectedCategory === 'all' || category.getAttribute('data-category') === selectedCategory) {
                category.style.display = 'block';
            } else {
                category.style.display = 'none';
            }
        });
    });
</script>
