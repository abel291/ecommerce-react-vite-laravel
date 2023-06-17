<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 overflow-hidden rounded-lg shadow']) }}>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </div>
</div>
