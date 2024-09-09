@props(['title', 'description'])

<div {{ $attributes->merge(['class' => 'flex justify-between']) }}>
    <dt class="text-neutral-500 dark:text-neutral-400">{{ $title }}</dt>
    <dd class="text-neutral-900 dark:text-neutral-100">{{ $description }}</dd>
</div>
