<x-waiter.layout>
    <x-waiter.navbar>
        <x-waiter.table-header :table="session('tableNo')">

        <div class="flex flex-col justify-center items-center">
            <div class="flex flex-col w-full">
                <form action="{{ route('addToCart.post') }}" method="POST" class="font-pop">
                    @csrf
                    <input type="hidden" name="productID" value="{{ $productDetails->productID }}">
                    <input type="hidden" name="name" value="{{ $productDetails->name }}">
                    <input type="hidden" name="price" value="{{ $productDetails->price }}">
                    <input type="hidden" name="image" value="{{ $productDetails->image }}">

                    <div class="px-7">
                        <div class="w-full bg-[#E1E1E1] h-56 rounded-lg mt-7"></div>
                        <div class="flex justify-between text-xl font-bold mt-4">
                            <p>{{ $productDetails->name }}</p>
                            <p class="text-red-700">{{ 'RM ' . $productDetails->price }}</p>
                        </div>

                        <div>
                            <p class="mt-4 text-lg">Description:</p>
                            <p>{{ $productDetails->description }}</p>
                        </div>
                    </div>

                    <div class="px-7 pb-28">
                        <div class="flex bg-[#EEEEEE] items-center mt-4 justify-between px-8 py-4 rounded-lg">
                            <label class="font-bold" for="takeaway">Takeaway</label>
                            <input name="takeaway" class="custom-radio bg-white" type="checkbox" value="Takeaway">
                        </div>

                        <!-- Loop through the categories with their options -->
                        @foreach ($categoriesWithOptions as $category)
                            <!-- Display category name -->
                            <p class="font-bold text-lg mt-7">{{ $category->name }}</p>

                            <!-- Check if the category has options -->
                            @if ($category->options->isEmpty())
                                <p class="text-sm text-gray-500">No options available for this category.</p>
                            @else
                                <!-- Loop through options for this category -->
                                @foreach ($category->options as $option)
                                    <hr class="mt-2">
                                    <div class="flex justify-between w-full items-center my-4">
                                        <label for="option-{{ $option->customizeOptionsID }}" class="text-gray-600">{{ $option->name }}</label>
                                        <input id="option-{{ $option->customizeOptionsID }}" type="checkbox" name="options[{{ $category->name }}][]" value="{{ $option->name }}" class="custom-radio bg-gray-200 appearance-none rounded-full w-6 h-6 border-none checked:bg-blue-500 checked:shadow-inner focus:outline-none">
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>

                    <div class="w-full bg-[#F3F3F3] py-6 fixed bottom-0 px-10 flex justify-between items-center">
                        <p class="text-2xl font-mont font-bold">{{ 'RM ' . $productDetails->price }}</p>
                        <button value="" type="submit" class="bg-blue-button text-white py-3 px-12 rounded-2xl">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
        </x-waiter.table-header>
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