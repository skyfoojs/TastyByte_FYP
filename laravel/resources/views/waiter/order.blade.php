@section('title', 'Waiter Order Page - TastyByte')

<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col mt-24">
            <x-waiter.table-header :table="'Table ' . session('tableNo')" :trackOrder="''">
                <div class="flex justify-center items-center mt-4 px-6">
                    <select class="w-full rounded-2xl py-3 px-4 bg-white appearance-none" name="categoryFilter" id="categoryFilter">
                        <option value="all">All Categories</option>
                        @foreach ($groupedProducts as $categoryName => $products)
                            <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col mb-32" id="productList">
                    @foreach ($groupedProducts as $categoryName => $products)
                        <div class="category-group" data-category="{{ $categoryName }}">
                            <div class="mt-6 mb-2 px-6">
                                <p class="text-2xl font-bold py-1">{{ $categoryName }}</p>

                                @foreach ($products as $product)
                                    @if ($product->status == 'Not Available')
                                        <div class="flex items-center py-3 rounded-xl">
                                            <div class="w-32 h-32 flex items-center justify-center bg-gray-300 rounded-s-xl">
                                                @if (!empty($product->image))
                                                    <img class="w-full h-full object-cover rounded-s-xl grayscale opacity-60" src="{{ asset($product->image) }}" alt="Image Not Available">
                                                @else
                                                    <p class="text-gray-500">No Image</p>
                                                @endif
                                            </div>
                                            <div class="flex-1 h-32 flex flex-col justify-center px-6 bg-gray-100 rounded-r-xl">
                                                <p class="text-gray-600 font-semibold">{{ $product->name }}</p>
                                                <p class="text-gray-500">{{ $product->price }}</p>
                                                <p class="text-red-600 text-base">Product not available</p>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('/product-details/' . $product->productID) }}">
                                            <div class="flex items-center py-3">
                                                <div class="w-32 h-32 flex items-center justify-center">
                                                    @if (!empty($product->image))
                                                        <img class="w-full h-full rounded-s-xl object-cover" src="{{ asset($product->image) }}" alt="Image Not Available">
                                                    @else
                                                        <p>No Image</p>
                                                    @endif
                                                </div>
                                                <div class="flex-1 h-32 flex flex-col justify-center px-6 bg-white rounded-r-xl">
                                                    <p class="text-gray-900 font-semibold text-lg">{{ $product->name }}</p>
                                                    <p class="text-gray-600 text-base">RM {{ number_format($product->price, 2) }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @if(session('cart'))
                        <div class="w-full bg-white p-6 fixed bottom-0">
                            <div class="bg-indigo-500 rounded-lg text-white flex items-center justify-center py-4 gap-x-2">
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
