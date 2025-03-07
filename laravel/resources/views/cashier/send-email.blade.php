@section('title', 'Send Email - TastyByte')

<x-cashier.layout>
    <x-cashier.navbar>
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative w-full max-w-md mx-auto">
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Enter Recipient Email</h2>

                        <form method="POST" action="{{ route('cashier.sendEmail') }}">
                            @csrf
                            <input name="emailAddress" type="email" id="emailAddress"
                                   class="mb-6 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Please enter recipient email address" required>
                            <input type="hidden" name="paymentID" value="{{ $paymentID }}">
                            <div class="flex justify-end space-x-4">
                                <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Confirm Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-cashier.navbar>
</x-cashier.layout>
