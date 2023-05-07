@section('title', $label)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <x-content>
        <form wire:submit.prevent="{{ $edit ? 'update' : 'save' }}">
            <x-form.section-form title="Datos Generales">
                <x-form.form-grid>

                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.name">Nombre</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.slug">Url</x-form.input-label-error>
                    </div>

                    <div class="sm:col-span-2">
                        <x-form.select wire:model.defer="product.active" label="Activo">
                            <option>Seleccione una opcion</option>
                            <option value="1">SI</option>
                            <option value="0">NO</option>
                        </x-form.select>

                    </div>
                    <div class="sm:col-span-4"></div>
                    <div class="sm:col-span-6">
                        <x-form.textarea rows="4" wire:model.defer="product.description_min"
                            label="Descripcion pequeña" />
                    </div>
                    <div class="sm:col-span-6">
                        <x-form.textarea rows="6" wire:model.defer="product.description_max"
                            label="Descripcion Amplia" />

                    </div>

                    <div class="sm:col-span-3">
                        <x-form.input-file :temp="$thum" model="thum" :saved="$product->thum"
                            label="Imagen miniatura" />
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-file :temp="$img" model="img" :saved="$product->img" label="Imagen amplia" />
                    </div>
                </x-form.form-grid>
            </x-form.section-form>

            <x-form.section-form title="Precio y descuentos">
                <x-form.form-grid>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.price">Precio</x-form.input-label-error>
                    </div>

                    <div class="sm:col-span-3">
                        <x-form.select wire:model.defer="product.offer" label="Descuento">
                            <option value="0">Sin ofeta</option>
                            <option value="10">10%</option>
                            <option value="20">20%</option>
                            <option value="30">30%</option>
                            <option value="40">40%</option>
                        </x-form.select>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.cost">
                            Costo</x-form.input-label-error>
                        <span class="text-gray-400 text-xs font-medium">Los clientes no verán este precio.</span>
                    </div>

                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.max_quantity">Cantidad maxima pór compra
                        </x-form.input-label-error>
                    </div>
                </x-form.form-grid>
            </x-form.section-form>

            <x-form.section-form title="Inventario y stock">
                <x-form.form-grid>


                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="stock.quantity">Stock (Unidad de mantenimiento de
                            existencias)</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="stock.remaining">Cantidad Restante
                        </x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="stock.barcode">Codigo de barra
                        </x-form.input-label-error>
                    </div>

                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="stock.supplier">Proveedor
                        </x-form.input-label-error>
                    </div>
                </x-form.form-grid>
            </x-form.section-form>

            <x-form.section-form title="Asociaciones">
                <x-form.form-grid>

                    <div class="sm:col-span-2">

                        <x-form.select wire:model.defer="product.category_id" label="Categoria">
                            <option>Selecione una categoria</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </x-form.select>

                    </div>

                    <div class="sm:col-span-2">
                        <x-form.select wire:model.defer="product.brand_id" label="Marca">
                            <option>Selecione una marca</option>
                            @foreach ($brands as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </x-form.select>

                    </div>
                </x-form.form-grid>
            </x-form.section-form>
            <div class="text-right mt-10">
                <a class="btn-secondary" href="{{ route('dashboard.products') }}">Volver</a>
                <x-primary-button wire:loading.attr="disabled" x-show="edit" class="ml-2"
                    wire:loading.attr="disabled">
                    {{ $edit ? 'Editar' : 'Guardar' }}
                </x-primary-button>
            </div>




        </form>
    </x-content>
</div>
