<x-waiter.layout>
    <x-waiter.navbar>
            <x-waiter.table-header :table="''" :trackOrder="'Choose '">
                <div class="flex flex-col pb-8">
                    <div class="flex justify-center items-center mt-4">
                        <select class="w-72 rounded-2xl py-1 px-4 bg-[#E6E6E6] border-r-[12px]" name="" id="">
                            <option value="">Test</option>
                        </select>
                        <i class='bx bx-search ml-5 bx-sm text-[#8E8E8E]'></i>
                    </div>

                    <div class="px-8">
                        @foreach ($orders as $order)
                            @foreach ($order->orderItems as $item)
                            @endforeach
                            <a href="{{ route('orderHistory', ['orderID' => $order->orderID]) }}">
                                <div class="bg-[#EDEDED] w-full p-5 rounded-xl mt-10">
                                    <div class="flex">
                                        <div class="space-y-3 ml-3">
                                            <div>
                                                <p><span class="font-semibold">Table:</span>&nbsp&nbsp{{ $order->tableNo }}</p>
                                                <p><span class="font-semibold">Status:</span>&nbsp&nbsp{{ $order->status }}</p>
                                                <p><span class="font-semibold">Total Amount:</span>&nbsp&nbsp{{ $order->totalAmount }}</p>
                                                <p><span class="font-semibold">Remark:</span>&nbsp&nbsp{{ $order->remark }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[#919191] text-sm"><span>Last Order:</span>&nbsp&nbsp{{ $order->created_at }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        @endforeach
                    </div>
                </div>
            </x-waiter.table-header>
    </x-waiter.navbar>
</x-waiter.layout>
