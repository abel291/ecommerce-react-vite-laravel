<x-form.section-form title="Precio y descuentos">
    <x-form.grid>
        <div class="sm:col-span-3">
            <x-form.input-group text="$" label="Precio" x-data x-mask:dynamic="$money($input)"
                wire:model.defer="product.price" />
        </div>

        <div class="sm:col-span-3">

            <x-form.select label="Descuentos" wire:model.defer="product.offer">
                <option value="0">Sin ofeta</option>
                <option value="10">10%</option>
                <option value="20">20%</option>
                <option value="30">30%</option>
                <option value="40">40%</option>
            </x-form.select>
        </div>
        <div class="sm:col-span-3">

            <x-form.input-group text="$" label="Costo" x-data x-mask:dynamic="$money($input)"
                wire:model.defer="product.cost" />

            <span class="text-gray-500 text-xs ">Los clientes no verán este precio.</span>
        </div>

        <div class="sm:col-span-3">
            <x-form.input-label-error wire:model.defer="product.max_quantity" x-mask:dynamic="$money($input)">
                Cantidad
                maxima pór compra
            </x-form.input-label-error>
        </div>
    </x-form.grid>
</x-form.section-form>
