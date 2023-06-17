@props(['text', 'label' => '', 'disabled' => false])
@php
    $id = $attributes->whereStartsWith('wire:model')->first();
@endphp
<div>
    @if ($label)
        <x-input-label for="{{ $id }}">{{ $label }}</x-input-label>
    @endif

    <div
        class="overflow-hidden flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md mt-2">
        <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">{{ $text }}</span>
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'type' => 'text',
            'class' => 'input-form mt-0  ring-0 focus:ring-0 border-0 bg-transparent',
        ]) !!}>
    </div>

    <x-input-error :model="$id" />
</div>
