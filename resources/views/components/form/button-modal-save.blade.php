<div class="text-right">
    <x-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
        Cerrar
    </x-secondary-button>

    {{ $slot }}

    <div class="inline-block">
        <x-primary-button x-show="edit" type="button" class="ml-2" wire:click="update" wire:loading.attr="disabled">
            Editar
        </x-primary-button>

        <x-primary-button x-show="!edit" type="button" class="ml-2" wire:click="save" wire:loading.attr="disabled">
            Guardar
        </x-primary-button>
    </div>

</div>
