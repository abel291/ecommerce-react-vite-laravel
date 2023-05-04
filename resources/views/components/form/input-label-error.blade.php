@props(['label' => ''])
<div>
    <x-input-label>{{ $slot }}</x-input-label>
    <x-text-input {{ $attributes }} />
    <x-input-error :model="$attributes->whereStartsWith('wire:model')->first()" />
</div>
