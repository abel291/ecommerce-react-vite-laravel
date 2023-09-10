<x-form.section-form title="Inventario y stock">
    <x-form.grid>


        <div class="md:col-span-2">
            <x-form.input-label-error wire:model.defer="stock.quantity">
                Stock
                (Unidad de mantenimiento de
                existencias)</x-form.input-label-error>
        </div>
        <div class="md:col-span-2">
            <x-form.input-label-error wire:model.defer="stock.remaining">
                Cantidad Restante
            </x-form.input-label-error>
        </div>
        <div class="md:col-span-2">
            <x-form.input-label-error wire:model.defer="stock.barcode">Codigo de barra
            </x-form.input-label-error>
        </div>

        <div class="md:col-span-5">
            <x-form.input-label-error wire:model.defer="stock.supplier">Proveedor
            </x-form.input-label-error>
        </div>
    </x-form.grid>
</x-form.section-form>
