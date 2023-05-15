<x-modal-create>
    <x-modal size="md" wire:target="create,edit,save,update">
        <x-slot name="title">
            {{ $label }}
        </x-slot>
        <x-slot name="content">

            <x-form.grid>

                <div class="lg:col-span-3">
                    <x-form.input-label-error wire:model.defer="brand.name">Nombre</x-form.input-label-error>
                </div>
                <div class="lg:col-span-3">
                    <x-form.input-label-error wire:model.defer="brand.slug">Slug</x-form.input-label-error>
                </div>
                <div class="lg:col-span-2">
                    <x-form.select-active wire:model.defer="brand.active" />
                </div>
                <div class="lg:col-span-5">
                    <x-form.input-label-error wire:model.defer="brand.website">Website</x-form.input-label-error>
                </div>

                <div class="lg:col-span-3">
                    <x-form.input-file :temp="$img" model="img" :saved="$brand->img" label="Imagen" />
                </div>

            </x-form.grid>
        </x-slot>
        <x-slot name="footer">
            <div class="text-right">

                <x-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                    Cerrar
                </x-secondary-button>

                <x-primary-button x-show="edit" type="button" class="ml-2" wire:click="update"
                    wire:loading.attr="disabled">
                    Editar
                </x-primary-button>

                <x-primary-button x-show="!edit" type="button" class="ml-2" wire:click="save"
                    wire:loading.attr="disabled">
                    Guardar
                </x-primary-button>

            </div>
        </x-slot>
    </x-modal>
    <x-modal-confirmation-delete />
</x-modal-create>
