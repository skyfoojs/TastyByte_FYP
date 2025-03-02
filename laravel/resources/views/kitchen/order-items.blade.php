<x-kitchen.layout>
    <x-kitchen.navbar>
        <div class="flex h-screen relative">
            <div class="w-full p-6 mt-25">
                <div class="flex items-center mt-2">
                    <a href="{{ route('kitchen.order-items', ['filter' => 'pending']) }}"
                       class="p-3 mr-4 {{ request('filter', 'pending') === 'pending' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        Pending
                    </a>
                    <a href="{{ route('kitchen.order-items', ['filter' => 'completed']) }}"
                       class="p-3 mr-4 {{ request('filter') === 'completed' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        Completed
                    </a>
                    <a href="{{ route('kitchen.order-items', ['filter' => 'all']) }}"
                       class="p-3 {{ request('filter') === 'all' ? 'bg-indigo-500 text-white' : 'bg-indigo-200 text-indigo-500' }}
                       tracking-normal px-10 rounded-full">
                        All
                    </a>
                </div>

                <div class="mt-6">
                    @if($orderItems->isEmpty())
                        <p class="text-center text-gray-500 text-lg font-semibold mt-10">No completed orders</p>
                    @else
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            @foreach($orderItems as $item)
                                <div class="bg-white p-4 shadow rounded-lg">
                                    <div class="flex justify-between items-center mb-4">
                                        <p class="text-gray-700 font-bold">
                                            {{ optional(json_decode($item->remark, true))['takeaway'] ?? false ? 'Takeaway' : 'Dine In' }}
                                        </p>
                                        <div class="flex items-center space-x-2">
                                            <p class="{{ $item->status === 'Pending' ? 'text-red-500 bg-red-100 px-4 py-2 text-sm rounded-full' : 'text-green-500 bg-green-100 px-4 py-2 text-sm rounded-full' }} font-bold">
                                                {{ $item->status }}
                                            </p>
                                            <p class="text-white bg-indigo-500 px-3 py-1 rounded-full">{{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <hr class="mb-2">
                                    <p class="text-gray-700"><strong>Order ID:</strong> {{ $item->orderID }}</p>
                                    <p class="text-gray-700"><strong>Table No:</strong> {{ $item->orders->tableNo }}</p>
                                    <p class="text-gray-700"><strong>Product:</strong> {{ $item->products->name }}</p>
                                    <p class="text-gray-700"><strong>Remark:</strong> {{ collect(optional(json_decode($item->remark, true))['options'] ?? [])->flatten()->join(', ') ?: '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-kitchen.navbar>
</x-kitchen.layout>
