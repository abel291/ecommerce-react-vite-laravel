@props(['label' => '', 'text' => ''])
@php
    $id = $attributes->get('wire:model.defer');
@endphp
<div class="flex items-start mt-2">
    <div class="flex h-5 items-center">
        <input id="{{ $id }}" type="radio" name="{{ $id }}"
            {{ $attributes->class('h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500') }}>
    </div>
    <label for="{{ $id }}" class="ml-2 font-medium text-sm">
        {{ $slot }}
    </label>
</div>
