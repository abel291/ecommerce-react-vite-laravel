@section('title', $label)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>

    <form wire:submit.prevent="{{ $edit ? 'update' : 'save' }}">
        <x-content>
            <x-form.section-form title="Datos Generales">
                <x-form.grid>

                    <div class="xl:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.name">Nombre</x-form.input-label-error>
                    </div>
                    <div class="lg:col-span-3">
                        <x-form.input-label-error wire:model.defer="product.slug">Url</x-form.input-label-error>
                    </div>

                    <div class="lg:col-span-1">
                        <x-form.select-active wire:model.defer="product.active" />
                    </div>
                    <div class="lg:col-span-4"></div>
                    <div class="lg:col-span-6">
                        <x-form.textarea rows="4" wire:model.defer="product.description_min"
                            label="Descripcion pequeña" />
                    </div>
                    <div class="lg:col-span-6">
                        <x-form.textarea rows="6" wire:model.defer="product.description_max"
                            label="Descripcion Amplia" />

                    </div>

                    <div class="lg:col-span-3">
                        <x-form.input-file :temp="$thumb" model="thumb" :saved="$product->thumb"
                            label="Imagen miniatura" />
                    </div>
                    <div class="lg:col-span-3">
                        <x-form.input-file :temp="$img" model="img" :saved="$product->img" label="Imagen amplia" />
                    </div>
                </x-form.grid>
            </x-form.section-form>
            @include('livewire.product.section-price')
            @include('livewire.product.section-stock')
            @include('livewire.product.section-association')


            <div class=" flex items-center justify-end gap-x-2	">
                <a class="btn-secondary" href="{{ route('dashboard.products') }}">Volver</a>
                <x-primary-button wire:loading.attr="disabled" x-show="edit" wire:loading.attr="disabled">
                    {{ $edit ? 'Editar' : 'Guardar' }}
                </x-primary-button>
            </div>
        </x-content>

    </form>


    {{-- @if ($edit)
        <div class="mt-10">
            <livewire:specification.list-specification :product-id="$product->id" />
        </div>
        <div class="mt-10">
            <livewire:image.list-image :model="$product" />
        </div>
    @endif --}}
</div>
