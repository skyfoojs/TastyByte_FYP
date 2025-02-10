<x-cashier.layout>
    <x-cashier.navbar>
        <div class="w-3/4 p-6 mt-26">
            <h2 class="text-xl font-bold mb-6 p-2">Order History - Table {{ session('tableNo') }}</h2>

            <div class="space-y-4">
                @if (session('cart'))
                    @foreach (session('cart') as $cartItem)
                        <div class="flex items-center justify-between bg-white p-4 shadow rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-28 h-28 border rounded-lg flex items-center justify-center">
                                    @if (!empty($cartItem['image']))
                                        <img class="w-full h-full rounded-lg object-cover" src="{{ asset($cartItem['image']) }}" alt="Image Not Available">
                                    @else
                                        <p>No Image</p>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-lg">{{ $cartItem['name'] }}</p>
                                    <p class="text-gray-600">RM {{ $cartItem['price'] }}</p>
                                    @if (!empty($cartItem['options']))
                                        <p class="text-sm text-gray-500">{{ collect($cartItem['options'])->map(function($values, $name) { return implode(', ', $values); })->implode(', ') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="border w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white mb-4">{{ $cartItem['quantity'] }}</span>
                                <button class="px-6 py-2 bg-gray-200 rounded-full text-sm tracking-wide">Split</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <x-cashier.sidebar>
        </x-cashier.sidebar>
    </x-cashier.navbar>
</x-cashier.layout>
