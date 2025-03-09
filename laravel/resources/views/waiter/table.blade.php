@section('title', 'Enter a Table No - TastyByte')

<x-waiter.layout>
    <x-waiter.navbar>
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative w-full p-8 max-w-md mx-auto">
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Enter Table Number</h2>

                        <form action="{{ route('storeTable') }}" method="POST">
                            @csrf
                            <input name="table" type="number" id="table"
                                   class="mb-6 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Please enter a table number" required>
                            <input type="hidden" name="source" value="waiter">
                            <div class="flex justify-end space-x-4">
                                <button type="submit" class="px-4 py-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(session('continueOrder'))
            <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

            <div id="continueOrderModal" class="fixed inset-0 flex items-center justify-center z-50 opacity-0 scale-90 pointer-events-none transition-all duration-300 ease-out">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Unpaid Order Detected</h2>
                    <p class="text-gray-700"><strong class="text-red-600">Table {{ session('tableNo') }}</strong> has an active order that hasn't been checked out. Do you want to continue adding items?</p>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Cancel</button>
                        <a href="{{ route('order') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg">Continue Ordering</a>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let modal = document.getElementById("continueOrderModal");
                    let overlay = document.getElementById("modalOverlay");

                    if (modal && overlay) {
                        overlay.classList.remove("hidden");
                        modal.classList.remove("opacity-0", "scale-90", "pointer-events-none");
                        modal.classList.add("opacity-100", "scale-100", "pointer-events-auto");
                    }
                });

                function closeModal() {
                    let modal = document.getElementById("continueOrderModal");
                    let overlay = document.getElementById("modalOverlay");

                    if (modal && overlay) {
                        modal.classList.remove("opacity-100", "scale-100", "pointer-events-auto");
                        modal.classList.add("opacity-0", "scale-90", "pointer-events-none");

                        setTimeout(() => {
                            modal.style.display = "none";
                            overlay.classList.add("hidden");
                        }, 300);
                    }
                }

                document.getElementById("modalOverlay").addEventListener("click", closeModal);
            </script>
        @endif
    </x-waiter.navbar>
</x-waiter.layout>
