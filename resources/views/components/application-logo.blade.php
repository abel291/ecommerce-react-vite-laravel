<a href="/" target='_blank'>
    <div class="flex items-center gap-x-3">
        <div class="rounded-full h-10 w-10 p-2 bg-neutral-800">
            <x-heroicon-m-shopping-cart class="w-full h-full text-white" />
        </div>
        <div {{ $attributes->class('text-indigo-600 text-lg text-center whitespace-nowrap font-light font-semibold') }}>
            {{ config('app.name') }}
        </div>
    </div>
</a>
