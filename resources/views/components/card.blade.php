@props(['title' => ''])
<div {{ $attributes->merge(['class' => 'relative w-full rounded-xl bg-white  border p-6']) }}>
    @if ($title)
        <div class="title mb-6">
            {{ $title }}
        </div>
    @endif
    <div class=" text-neutral-900 dark:text-neutral-100 ">
        {{ $slot }}
    </div>
</div>
