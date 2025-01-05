<x-layout>
<div class="flex flex-col h-screen bg-[#F5F5F5] items-center">
    <div class="flex bg-white w-full justify-center items-center shadow-[0px_2px_10px_0px_rgba(0,0,0,0.25)]">
        <img class="w-52 pt-3 pb-2" src="{{ asset('images/' . 'TastyByte-Banner.png') }}" alt="">
    </div>

    <div class="mt-1 flex flex-col justify-center items-center">
        <h1 class="font-semibold mt-5">Restaurant's Information</h1>

        <div class="flex py-4 px-8 gap-4 bg-white shadow-[2px_2px_10px_0px_rgba(0,0,0,0.25)] mt-4 mx-4 rounded-xl">
            <img class="w-24 rounded-2xl" src="{{ asset('images/' . 'VTEN-Kopitiam-Logo.jpg') }}" alt="Logo.jpg">
            <p class="text-xs text-[#7A7A7A] leading-5 text-center mt-2">VTEN Kopitiam, Level 12, Menara PJH, Jalan Tun Abdul Razak, Precinct 2 Putrajaya, 62100, Selangor Malaysia</p>
        </div>
    </div>

    <div class="mt-12 flex flex-col justify-center items-center">
        <h1 class="font-bold">LOGIN WITH</h1>
        <form action="" method="POST" class="pt-2 flex flex-col">

            <label for="email">Email:</label>
            <input class="mt-1 border border-[#D8D8D8] rounded-md py-2 px-2 w-60" placeholder="Enter Your Email Address" type="email">

            <label class="mt-3" for="password">Password:</label>
            <input class="mt-1 border border-[#D8D8D8] rounded-md py-2 px-2 w-60" placeholder="Enter Your Password" type="password">

            <button class="py-2 px-20 bg-blue-button text-white rounded-xl mt-3 font-medium" value="submit" type="submit">LET'S GO</button>
        </form>
    </div>
</div>
</x-layout>