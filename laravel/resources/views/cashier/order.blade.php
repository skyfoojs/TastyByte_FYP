<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen">
            <div class="w-3/4 p-6 mt-25">
                <!-- Select and search bar -->
                <div class="flex items-center space-x-4 mt-2">
                    <select class="p-2 bg-white px-10 rounded-full">
                        <option>All Categories</option>
                        @foreach ($groupedProducts as $categoryName => $products)
                            <option>{{ $categoryName }}</option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="Search ..." class="p-2 bg-white rounded-full w-1/3 ps-4">
                </div>

                @foreach ($groupedProducts as $categoryName => $products)
                    <h2 class="text-xl font-bold mb-4 p-2 mt-6">{{ $categoryName }}</h2>

                    <div class="overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            @if ($product->status == 'Not Available')
                                <div class="bg-gray-300 rounded-lg shadow-md overflow-hidden w-80 opacity-50">
                                    <img src="{{ asset($product->image) }}" alt="Image Not Available" class="w-full h-60 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold mb-2">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-2">Product not available</p>
                                        <span class="text-lg font-semibold text-gray-500">RM {{ number_format($product->price, 2) }}</span>
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/product-details/' . $product->productID) }}">
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden w-80">
                                        <img src="{{ asset($product->image) }}" alt="Image Not Available" class="w-full h-60 object-cover">
                                        <div class="p-4">
                                            <h3 class="text-lg font-bold mb-2">{{ $product->name }}</h3>
                                            <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-lg text-slate-800 font-semibold">RM {{ number_format($product->price, 2) }}</span>
                                                <div class="flex items-center bg-slate-200 rounded-full p-1">
                                                    <button class="bg-white px-3 py-1 font-bold rounded-full">-</button>
                                                    <span class="mx-4">1</span>
                                                    <button class="bg-zinc-800 text-white px-3 py-1 font-bold rounded-full">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>

            <x-cashier.sidebar>

            </x-cashier.sidebar>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>
