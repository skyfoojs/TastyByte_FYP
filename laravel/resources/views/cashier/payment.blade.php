@section('title', 'Payment Successfully - TastyByte')

<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex items-center justify-center h-screen">
            <div class="bg-white p-20 rounded-lg shadow-lg text-center">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-6xl text-green-500 mx-auto"></i>
                </div>
                <h2 class="text-xl font-bold mb-8">Payment Successfully</h2>
                <a href="{{ route('cashier.email', ['paymentID' => request()->query('paymentID')]) }}" class="w-full bg-white border px-4 py-2 rounded inline-block mb-4">Send Digital Invoices</a>
                <a href="{{ route('trackOrder') }}" class="w-full text-center bg-gray-400 text-white px-4 py-2 rounded inline-block">Close</a>
            </div>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>