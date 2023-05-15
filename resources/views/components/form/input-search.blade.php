<div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3">
    <div>
        <x-text-input type="text" wire:model.debounce.500ms="search" placeholder="Buscar" class="md:w-64" />
    </div>
    {{ $slot }}
    <x-spinner-loading wire:loading class="mt-1" />

</div>
