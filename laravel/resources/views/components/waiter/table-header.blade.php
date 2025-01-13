<div class="flex w-full mt-4 items-center justify-center relative">
    <i class='bx bx-chevron-left bx-md absolute left-3 cursor-pointer' onclick="window.history.back()"></i>

    <!-- TODO: Implement dynamic table number. -->
    <div class="text-lg font-semibold">Table {{ $table }}</div>
</div>

<main>
    {{ $slot }}
</main>