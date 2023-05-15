@props(['title'])
<div class="mb-8 pb-8 border-b">
    <x-form.title>{{ $title }}</x-form.title>
    <div {{ $attributes }}>
        {{ $slot }}
    </div>
</div>
