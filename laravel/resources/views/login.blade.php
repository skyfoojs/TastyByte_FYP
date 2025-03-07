<x-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-slate-200 p-4">
        <div class="flex flex-col justify-center items-center bg-white p-6 md:p-12 rounded-2xl shadow-lg w-full max-w-sm md:max-w-lg">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/' . 'Logo.png') }}" alt="Logo" class="w-12 h-12 md:w-14 md:h-14">
                <p class="text-gray-800 text-2xl font-bold md:text-3xl">TastyByte</p>
            </div>
            <hr class="w-full border-t-1 border-gray-300 mt-6">
            <h1 class="mt-6 font-semibold text-center text-gray-700 text-lg md:text-lg">Restaurant's Information</h1>
            <p class="text-base text-gray-600 leading-5 text-center mt-2 px-4">
                Vten Kopitiam, Level 12, Menara PJH, Jalan Tun Abdul Razak, Precinct 2 Putrajaya, 62100, Selangor Malaysia
            </p>
            <hr class="w-full border-t-1 border-gray-300 mt-6">

            @if (session('error'))
                <span class="w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg text-base md:text-lg">{{ session('error') }}</span>
            @elseif(session('logoutSuccess'))
                <span class="w-full bg-red-200 text-center m-3 text-gray-600 p-3 rounded-lg text-base md:text-lg">{{ session('logoutSuccess') }}</span>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="mt-6 flex flex-col w-full">
                @csrf
                <label for="email_or_username" class="text-lg font-medium">Email/ Username</label>
                <input required name="email_or_username" class="mt-2 border border-gray-300 rounded-lg px-4 py-2 w-full max-w-xs md:max-w-md focus:ring-indigo-500 focus:border-indigo-500 text-base" placeholder="Enter Email or Username" type="text">

                <label class="mt-3 text-lg font-medium" for="password">Password</label>
                <input required name="password" class="mt-1 border border-[#D8D8D8] rounded-md py-2 px-4 w-full max-w-xs md:max-w-md text-base" placeholder="Enter Password" type="password">

                <button class="py-2 w-full bg-indigo-500 text-white rounded-full mt-8 font-bold text-lg">Log In</button>
            </form>
        </div>
    </div>
</x-layout>
