<x-waiter.layout>
    <x-waiter.navbar>
        <x-waiter.table-header :table="'Table Number'" :trackOrder="''">
            <div class="absolute inset-0 flex justify-center items-center px-4">
                <div class="flex flex-col bg-white p-6 shadow-lg rounded-lg w-full max-w-xs">
                    <p class="text-xl font-bold">Please Enter the Table Number</p>

                    <form action="{{ route('storeTable') }}" method="POST">
                        @csrf
                        <input name="table" type="number" id="table" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 mt-6" required>
                        <div class="flex justify-end space-x-4 mt-6">
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>