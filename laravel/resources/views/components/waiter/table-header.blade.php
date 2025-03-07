<div class="flex w-full mt-4 items-center justify-center relative">
    <i class='bx bx-chevron-left bx-md absolute left-3 cursor-pointer' onclick="window.history.back()"></i>

    <div class="text-lg font-semibold">{{ $trackOrder }} {{ $table }}</div>
</div>

<main>
    {{ $slot }}
</main>
