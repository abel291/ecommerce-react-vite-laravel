@props(['title' => ''])
<div {{ $attributes->merge(['class' => 'p-6 bg-white dark:bg-gray-800 overflow-hidden rounded-lg shadow']) }}>
    @if ($title)
        <div class="text-base font-semibold leading-6 rounde border-b pb-4 mb-4">
            {{ $title }}
        </div>
    @endif
    <div class=" text-gray-900 dark:text-gray-100 ">
        {{ $slot }}
    </div>
</div>
