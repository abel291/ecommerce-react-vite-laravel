@props(['label' => '', 'text' => ''])
@php
    $id = $attributes->get('wire:model.defer');
@endphp
<div class="flex items-start mt-2">
    <div class="flex h-5 items-center">
        <input id="{{ $id }}" type="radio" name="{{ $id }}" {{ $attributes->class('input-radio') }}>
    </div>
    <label for="{{ $id }}" class="ml-2 font-medium text-sm">
        {{ $slot }}
    </label>
</div>
