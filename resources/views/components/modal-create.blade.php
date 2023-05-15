@props(['id' => ''])
<div>
    <div x-data="{
        show: @entangle('open').defer,
        edit: false,
    }"
        @modal-edit{{ $id }}.window="show = true; edit= true; $wire.edit($event.detail);"
        @modal-create{{ $id }}.window="show = true; edit= false; $wire.create();">
        {{ $slot }}
    </div>
</div>
