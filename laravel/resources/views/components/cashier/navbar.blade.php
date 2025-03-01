<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-26 items-center justify-between">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex shrink-0 items-center">
                    <img class="h-10 w-auto"
                         src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
                         alt="Your Company">
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-6">
                        <a href="#"
                           class="rounded-md px-5 py-4 text-lg font-bold text-gray-300">Dashboard</a>
                        <a href="/cashier/table"
                           class="rounded-md bg-gray-900 px-5 py-4 text-lg font-bold text-white hover:bg-gray-700 hover:text-white"
                           aria-current="page">Order Food</a>
                        <a href="/track-order"
                           class="rounded-md px-5 py-4 text-lg font-bold text-gray-300 hover:bg-gray-700 hover:text-white">Order
                            History</a>
                        <a href="#"
                           class="rounded-md px-5 py-4 text-lg font-bold text-gray-300 hover:bg-gray-700 hover:text-white">Check
                            Inventory</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="relative ml-3">
                    <div>
                        <button type="button"
                                class="relative flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <img class="size-12 rounded-full"
                                 src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<main>
    {{ $slot }}
</main>
