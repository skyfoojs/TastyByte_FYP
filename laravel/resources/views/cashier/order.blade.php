@section('title', 'Cashier Order Page - TastyByte')

<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen relative">
            <div class="w-3/4 p-6 mt-25">
                <!-- Select and search bar -->
                <div class="flex items-center space-x-4 mt-2 mb-6">
                    <select id="categoryFilter" class="bg-white px-10 py-2 rounded-full border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="all">All Categories</option>
                        @foreach ($groupedProducts as $categoryName => $products)
                            <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                        @endforeach
                    </select>
                    <input type="text" id="searchInput" placeholder="Search ..." class="py-2 bg-white border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full w-1/3 ps-4">
                </div>

                @foreach ($groupedProducts as $categoryName => $products)
                    <h2 class="category-title text-xl font-bold mb-4 p-2" data-category="{{ $categoryName }}">{{ $categoryName }}</h2>

                    <div class="product-grid overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-10" data-category="{{ $categoryName }}">
                        @foreach ($products as $product)
                            <div class="product-item {{ $product->status == 'Not Available' ? 'opacity-50' : '' }} bg-white rounded-lg shadow-md overflow-hidden w-80 cursor-pointer" data-name="{{ $product->name }}" data-category="{{ $categoryName }}" onclick='openBottomSheet({{ $product->productID }})'>
                                <img src="{{ asset($product->image) }}" alt="Image Not Available" class="w-full h-60 object-cover">
                                <div class="p-4">
                                    <h3 class="text-lg font-bold mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg text-slate-800 font-semibold">RM {{ number_format($product->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <x-cashier.sidebar></x-cashier.sidebar>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>

<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const products = document.querySelectorAll('.product-item');
        const categoryTitles = document.querySelectorAll('.category-title');

        products.forEach(product => {
            const productName = product.getAttribute('data-name').toLowerCase();
            product.style.display = productName.includes(searchValue) ? '' : 'none';
        });

        categoryTitles.forEach(title => {
            const category = title.getAttribute('data-category');
            const relatedProducts = document.querySelectorAll(`.product-grid[data-category="${category}"] .product-item`);

            let hasVisibleProducts = false;
            relatedProducts.forEach(product => {
                if (product.style.display !== 'none') {
                    hasVisibleProducts = true;
                }
            });

            title.style.display = hasVisibleProducts ? '' : 'none';
        });
    });

    document.getElementById('categoryFilter').addEventListener('change', function () {
        const selectedCategory = this.value;
        const productGrids = document.querySelectorAll('.product-grid');
        const categoryTitles = document.querySelectorAll('.category-title');

        productGrids.forEach(grid => {
            const category = grid.getAttribute('data-category');
            if (selectedCategory === 'all' || category === selectedCategory) {
                grid.style.display = '';
            } else {
                grid.style.display = 'none';
            }
        });

        categoryTitles.forEach(title => {
            const category = title.getAttribute('data-category');
            if (selectedCategory === 'all' || category === selectedCategory) {
                title.style.display = '';
            } else {
                title.style.display = 'none';
            }
        });
    });
</script>
