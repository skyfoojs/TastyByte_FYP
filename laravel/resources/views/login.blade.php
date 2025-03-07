<x-layout>
    <div class="min-h-screen flex justify-center items-center bg-slate-200">
        <div class="mt-12 flex flex-col justify-center items-center bg-white p-18 rounded-2xl">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12">
                <p class="text-gray-800 text-2xl font-bold">TastyByte</p>
            </div>
            <hr class="w-full border-t-1 border-gray-300 mt-6">
            @if (session('error'))
                <span class="w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg">{{ session('error') }}</span>
            @elseif(session('logoutSuccess'))
                <span class="w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg">{{ session('logoutSuccess') }}</span>
            @endif
            <form action="{{ route('login.post') }}" method="POST" class="pt-2 mt-6 flex flex-col">
                @csrf
                <label for="email_or_username">Email/ Username</label>
                <input required name="email_or_username" class="mt-2 border border-gray-300 rounded-lg px-3 py-2 flex-1 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Email or Username" type="text">

                <label class="mt-3" for="password">Password</label>
                <input required name="password" class="mt-1 border border-[#D8D8D8] rounded-md py-2 px-4 w-60 md:w-80" placeholder="Enter Password" type="password">

                <button class="py-2 px-20 bg-indigo-500 text-white rounded-full mt-6 font-bold" value="submit" type="submit">Log In</button>
            </form>
        </div>
    </div>
</x-layout>
