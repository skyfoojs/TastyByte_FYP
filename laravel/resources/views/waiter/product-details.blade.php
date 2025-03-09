@section('title', 'Product Details Page - TastyByte')

<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex flex-col mt-24">
            <x-waiter.table-header :table="'Table ' . session('tableNo')" :trackOrder="''">

            <div class="flex justify-center items-center">
                <div class="flex flex-col w-full">
                    <form action="{{ route('addToCart.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="productID" value="{{ $productDetails->productID }}">
                        <input type="hidden" name="name" value="{{ $productDetails->name }}">
                        <input type="hidden" name="price" value="{{ $productDetails->price }}">
                        <input type="hidden" name="image" value="{{ $productDetails->image }}">

                        <div class="px-7">
                            <div class="w-full bg-[#E1E1E1] h-56 rounded-lg mt-7">
                                @if (!empty($productDetails->image))
                                    <img class="w-full h-full rounded-lg object-cover" src="{{ asset($productDetails->image) }}" alt="Image Not Available">
                                @else
                                    <p>No Image</p>
                                @endif
                            </div>
                            <div class="flex justify-between text-xl font-bold mt-4">
                                <p>{{ $productDetails->name }}</p>
                                <p class="text-red-700">{{ 'RM ' . $productDetails->price }}</p>
                            </div>

                            <p class="text-gray-600 mt-2">{{ $productDetails->description }}</p>
                        </div>

                        <div class="px-7 pb-28">
                            <div class="flex bg-white items-center mt-4 justify-between px-8 py-4 rounded-lg">
                                <label class="font-bold text-base tracking-wide text-gray-700" for="takeaway">Takeaway</label>
                                <input name="takeaway" class="custom-radio bg-gray-200" type="checkbox" value="Takeaway">
                            </div>

                            <!-- Loop through the categories with their options -->
                            @if ($categoriesWithOptions->isNotEmpty())
                                @foreach ($categoriesWithOptions as $category)
                                    <!-- Display category name -->
                                    <p class="font-bold text-lg mt-7">{{ $category->name }}</p>

                                    <!-- Check if the category has options -->
                                    @if ($category->options->isEmpty())
                                        <p class="text-sm text-gray-500">No options available for this category.</p>
                                    @else
                                        <!-- Loop through options for this category -->
                                        <div data-required-group="{{ $category->name }}">
                                            @if ($category->options->where('status', 'Available')->isEmpty())
                                                <p class="text-gray-500 mt-4">No available options.</p>
                                            @endif
                                                @foreach ($category->options as $option)
                                                    <hr class="my-3 border-gray-300">
                                                    <span class="error-message text-red-500 text-sm ml-2 hidden"></span>
                                                    <div class="flex justify-between w-full items-center my-4">
                                                        @if ($option->status === "Available")
                                                            <label for="option-{{ $option->customizeOptionsID }}" class="text-gray-600">{{ $option->name }}</label>
                                                            <input {{ $category->isRequired ? 'data-required' : '' }} id="option-{{ $option->customizeOptionsID }}" type="{{ $category->singleChoose ? 'radio' : 'checkbox' }}" name="options[{{ $category->name }}][]" value="{{ $option->name }}" class="custom-radio bg-gray-100 appearance-none rounded-full w-6 h-6 border-none checked:bg-blue-500 checked:shadow-inner focus:outline-none">
                                                        @endif
                                                    </div>
                                                @endforeach
                                        </div>
                                    @endif
                                @endforeach

                            @else
                                <p class="mt-10 text-md text-gray-500 text-center">No customize category available.</p>
                            @endif
                        </div>

                        <div class="w-full bg-[#F3F3F3] py-6 fixed bottom-0 px-10 flex justify-between items-center">
                            <p class="text-2xl font-mont font-bold">{{ 'RM ' . $productDetails->price }}</p>
                            <button value="" type="submit" class="bg-indigo-500 text-white py-3 px-12 rounded-2xl">Add to Cart</button>
                        </div>
                    </form>
                </div>
            </div>
            </x-waiter.table-header>
        </div>
    </x-waiter.navbar>
</x-waiter.layout>

<style>
.custom-radio {
    appearance: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: inline-block;
    border: none;
    position: relative;
    cursor: pointer;
}

.custom-radio:checked {
    background-color: #3B82F6;
}

.custom-radio:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background-color: #ffffff;
    border-radius: 50%;
}

</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let isValid = true; // Flag to track form validity

        document.querySelectorAll("[data-required-group]").forEach(group => {
            const checkboxes = group.querySelectorAll("input[type='checkbox']");

            // Only check for required checkboxes, ignore radio buttons
            if (checkboxes.length > 0 && [...checkboxes].some(cb => cb.hasAttribute("data-required"))) {
                const errorMessageSpan = group.querySelector('.error-message');

                if (![...checkboxes].some(cb => cb.checked)) {
                    isValid = false; // Set validity to false if validation fails
                    errorMessageSpan.textContent = `Please select at least one option for ${group.dataset.requiredGroup}`; // Show error message
                    errorMessageSpan.classList.remove('hidden'); // Show the error message
                } else {
                    errorMessageSpan.classList.add('hidden'); // Hide error message if the checkbox is checked
                }
            }
        });

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
</script>
