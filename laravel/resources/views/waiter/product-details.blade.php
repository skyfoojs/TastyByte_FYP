<x-layout>
    <x-navbar>
        <x-table-header>

        <div class="flex flex-col justify-center items-center">
            <div class="flex flex-col w-full">
                <form action="" class="font-pop">
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

                    <div class="px-7">
                        <div class="flex bg-[#EEEEEE] items-center mt-4 justify-between px-8 py-4 rounded-lg">
                            <label class="font-bold" for="takeaway">Takeaway</label>
                            <input class="custom-radio bg-white" type="radio" value="takeaway">
                        </div>

                        <!-- Loop through the grouped customizable details -->
                        @foreach ($groupedCustomizableDetails as $categoryName => $customizableOptions)
                            <!-- Display category name -->
                            <p class="font-bold text-lg mt-7">{{ $categoryName }}</p>

                            <!-- Loop through options for this category -->
                            @foreach ($customizableOptions as $option)
                                <hr class="mt-2">
                                <div class="flex justify-between w-full items-center my-4">
                                    <label class="text-[#999]">{{ $option->name }}</label>
                                    <input type="radio" name="{{ $categoryName }}_option" value="{{ $option->id }}" class="custom-radio bg-[#ECECEC]">
                                </div>
                            @endforeach
                        @endforeach
                    </div>


                    <div class="w-full bg-[#F3F3F3] py-6 sticky bottom-0 px-10 flex justify-between items-center">
                        <p class="text-2xl font-mont font-bold">{{ 'RM ' . $productDetails->price }}</p>
                        <button value="" type="submit" class="bg-blue-button text-white py-3 px-12 rounded-2xl">Add to Cart</button>
                    </div>
                </form>
            </div>
        </div>
        </x-table-header>
    </x-navbar>
</x-layout>

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