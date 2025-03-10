@section('title', 'Cashier Order Page - TastyByte')

<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex h-screen relative">
            <div class="w-3/4 p-6 mt-25">
                <!-- Select and search bar -->
                <div class="flex items-center space-x-4 mt-2 mb-6">
                    <select class="bg-white px-10 py-2 rounded-full border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>All Categories</option>
                        @foreach ($groupedProducts as $categoryName => $products)
                            <option>{{ $categoryName }}</option>
                        @endforeach
                    </select>
                    <input type="text" placeholder="Search ..." class="py-2 bg-white border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full w-1/3 ps-4">
                </div>

                @foreach ($groupedProducts as $categoryName => $products)
                    <h2 class="text-xl font-bold mb-4 p-2">{{ $categoryName }}</h2>

                    <div class="overflow-y-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-10">
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
                                <div class="bg-white rounded-lg shadow-md overflow-hidden w-80 cursor-pointer"
                                     onclick='openBottomSheet({{ $product->productID }})'>
                                <img src="{{ asset($product->image) }}" alt="Image Not Available" class="w-full h-60 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold mb-2">{{ $product->name }}</h3>
                                        <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg text-slate-800 font-semibold">RM {{ number_format($product->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>

            <x-cashier.sidebar></x-cashier.sidebar>
        </div>

        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

        <!-- Bottom Sheet for Product Details -->
        <div id="bottom-sheet" class="fixed bottom-0 left-0 w-full bg-slate-200 shadow-xl transform translate-y-full transition-transform duration-300 rounded-t-3xl h-3/4 z-40">
            <div class="flex h-full">
                <form action="{{ route('cashier.addToCart.post') }}" method="POST" class="flex w-full">
                    @csrf
                    <input type="hidden" id="productID" name="productID">
                    <input type="hidden" id="hidden-name" name="name">
                    <input type="hidden" id="hidden-price" name="price">
                    <input type="hidden" id="hidden-image" name="image">

                    <div class="px-10 w-1/4 flex flex-col">
                        <!-- Product Image -->
                        <img id="product-image" class="h-72 w-72 rounded-xl mt-10" src="" alt="Product Image">

                        <!-- Product Name & Price -->
                        <div class="mt-4">
                            <p id="product-name" class="font-bold text-lg"></p>
                            <p id="product-description" class="text-slate-600 text-base"></p>
                            <p id="product-price" class="mt-2 text-red-700 text-lg font-bold"></p>
                        </div>

                        <!-- Takeaway Option -->
                        <div class="flex bg-white items-center mt-4 justify-between px-8 py-4 rounded-lg">
                            <label class="font-bold text-gray-600 tracking-wide" for="takeaway">Takeaway</label>
                            <input name="takeaway" class="custom-radio bg-gray-200 appearance-none rounded-full w-5 h-5 border-none checked:bg-indigo-500 checked:shadow-inner focus:outline-none" type="checkbox" value="Takeaway">
                        </div>
                    </div>

                    <div class="px-10 w-3/4 flex flex-col justify-between">
                        <!-- Customization Options -->
                        <div id="customization-section" class="mt-4"></div>

                        <!-- Add to Cart Section -->
                        <div class="py-6 px-10 flex justify-end mb-6">
                            <button type="submit" class="bg-indigo-500 shadow-lg shadow-indigo-500/50 text-white font-medium py-3 px-12 rounded-2xl" id="final-price"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>

<script>
    async function openBottomSheet(productID) {
        try {
            const overlay = document.getElementById('modalOverlay');
            // Ensure the sheet is hidden first
            document.getElementById("bottom-sheet").classList.add("translate-y-full");
            document.getElementById("bottom-sheet").classList.remove("hidden"); // Remove hidden class
            document.getElementById("bottom-sheet").classList.add("show"); // Add show class

            let response = await fetch(`/cashier/order/edit/${productID}`);

            // Validate JSON response
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Invalid response format: Not JSON");
            }

            let data = await response.json();

            if (!data.success) {
                alert("Failed to load product details");
                return;
            }

            // Update product details
            document.getElementById("product-name").textContent = data.product.name;
            document.getElementById("product-price").textContent = "RM " + parseFloat(data.product.price).toFixed(2);
            document.getElementById("product-description").textContent = data.product.description;
            document.getElementById("product-image").src = data.product.image;

            // Update hidden input fields
            document.getElementById("productID").value = data.product.productID;
            document.getElementById("hidden-name").value = data.product.name;
            document.getElementById("hidden-price").value = data.product.price;
            document.getElementById("hidden-image").value = data.product.image;
            document.getElementById("final-price").textContent = "Add to Cart - RM " + parseFloat(data.product.price).toFixed(2);

            // Handle customization options
            const customizationSection = document.getElementById("customization-section");
            customizationSection.innerHTML = "";

            if (data.categories.length > 0) {
                data.categories.forEach(category => {
                    let categoryHTML = `<p class="font-bold text-lg mt-7">${category.name}</p>`;

                    if (category.options.length === 0) {
                        categoryHTML += `<p class="text-sm text-gray-500">No options available.</p>`;
                    } else {
                        category.options.forEach(option => {
                            categoryHTML += `
                        <hr class="my-3 border-gray-300">
                        <div class="flex justify-between w-full items-center my-4">
                            <label for="option-${option.id}" class="text-gray-600">${option.name}</label>
                            <input id="option-${option.id}" type="${category.singleChoose ? 'radio' : 'checkbox'}"
                                name="options[${category.name}][]" value="${option.name}"
                                class="custom-radio bg-gray-100 appearance-none rounded-full w-6 h-6 border-none checked:bg-indigo-500 checked:shadow-inner focus:outline-none">
                        </div>`;
                        });
                    }

                    customizationSection.innerHTML += categoryHTML;
                });
            } else {
                customizationSection.innerHTML = `<p class="text-gray-500">No customizations available.</p>`;
            }

            setTimeout(() => {
                overlay.classList.remove('hidden');
                document.getElementById("bottom-sheet").classList.remove("translate-y-full");
            }, 50);

        } catch (error) {
            console.error("Error fetching product details:", error);
            alert("Failed to fetch product details. Please try again.");
        }
    }

    function closeBottomSheet() {
        document.getElementById('bottom-sheet').classList.add('translate-y-full');
        document.getElementById('bottom-sheet').classList.remove('show');
        document.getElementById('modalOverlay').classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        let bottomSheet = document.getElementById('bottom-sheet');
        if (!bottomSheet.contains(event.target) && !event.target.closest('.cursor-pointer')) {
            closeBottomSheet();
        }
    });
</script>

<style>
    #bottom-sheet {
        height: 75vh;
        overflow-y: auto;
        display: none;
    }
    #bottom-sheet.show {
        display: block;
    }
</style>
