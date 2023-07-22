<x-modal-create>
    <x-modal size="md" wire:target="create,edit,save">
        <x-slot name="title">
            {{ $label }}
        </x-slot>
        <x-slot name="content">

            <x-form.grid>
                <div class="lg:col-span-3">
                    <x-form.input-label-error wire:model.defer="specification.name">Nombre</x-form.input-label-error>
                </div>
                <div class="lg:col-span-6">
                    <x-form.input-label-error wire:model.defer="specification.type">Tipo</x-form.input-label-error>
                </div>
                <div class="lg:col-span-6">
                    <x-form.input-label-error wire:model.defer="specification.value">Valor</x-form.input-label-error>
                </div>
                <div class="lg:col-span-2">
                    <x-form.select-active wire:model.defer="specification.active" />
                </div>
            </x-form.grid>
        </x-slot>
        <x-slot name="footer">
            <div class="text-right">
                <x-form.button-modal-save />
            </div>
        </x-slot>
    </x-modal>
    <x-modal-confirmation-delete />
</x-modal-create>
