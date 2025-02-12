<x-waiter.layout>
    <x-waiter.navbar>
        <x-waiter.table-header :table="'Table Number'" :trackOrder="''">
        <div class="flex flex-col justify-center items-center">
            <div class="mt-20">
                <p class="text-xl">Please Enter the Table Number</p>
            </div>

            <form action="{{ route('storeTable') }}" method="POST">
                @csrf
                <input name="table" type="number" id="table" class="w-72 border border-gray-300 rounded-lg py-2 px-3 mt-10 bg-[#DDDDDD]" required>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium py-2 px-4 rounded-lg flex items-center space-x-2 mt-10">
                    <span>Confirm</span>
                </button>
            </form>
        </div>
        </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>