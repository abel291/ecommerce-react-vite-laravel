<div {{ $attributes->merge(['class' => 'relative w-full rounded-xl bg-white border']) }}>
    <div class="h-full w-full p-6 py-8 sm:p-8">
        {{ $slot }}
    </div>
</div>
