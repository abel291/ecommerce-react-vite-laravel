@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>

    <form wire:submit.prevent="update">
        <x-content>
            <div class="divide-y mt-5">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-10 pb-10 ">
                    <div>
                        <x-form.title>Ajustes Generales</x-form.title>
                    </div>
                    <div class="lg:col-span-2">
                        <x-form.grid>
                            <div class="xl:col-span-4">
                                <x-form.input-label-error wire:model.defer="settings.company.name">
                                    Nombre de la empresa
                                </x-form.input-label-error>
                            </div>
                            <div></div>
                            <div class="lg:col-span-4">
                                <x-form.input-label-error type='email' wire:model.defer="settings.company.email">Email
                                </x-form.input-label-error>
                            </div>
                            <div></div>
                            <div class="lg:col-span-3">
                                <x-form.input-label-error wire:model.defer="settings.company.phone">Telefono
                                </x-form.input-label-error>
                            </div>
                            <div class="lg:col-span-6">
                                <x-form.textarea rows="3" wire:model.defer="settings.company.entry"
                                    label="Eslogan" />
                            </div>
                            {{-- <div class="lg:col-span-4"></div> --}}
                            <div class="lg:col-span-6">
                                <x-form.textarea rows="2" wire:model.defer="settings.company.address"
                                    label="Direccion" />
                            </div>

                            <div class="lg:col-span-3">
                                <x-form.input-file :temp="$logo" model="logo" :saved="$settings['company']['logo']" label="Logo" />
                            </div>
                        </x-form.grid>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-10 py-10 ">
                    <div>
                        <x-form.title>Tarifas</x-form.title>
                    </div>
                    <div class="lg:col-span-2">
                        <x-form.grid>

                            <div class="lg:col-span-2">
                                <x-form.input-label-error type="number" min="0" max="100"
                                    wire:model.defer="settings.rates.tax">
                                    Impuestos
                                </x-form.input-label-error>
                            </div>
                            <div class="lg:col-span-4"></div>

                            <div class="lg:col-span-2">
                                <x-form.input-label-error type="number" min="0"
                                    wire:model.defer="settings.rates.shipping">
                                    Envio
                                </x-form.input-label-error>
                            </div>

                        </x-form.grid>
                    </div>
                </div>

            </div>
            <div class=" flex items-center justify-end gap-x-2	">
                <a class="btn-secondary" href="{{ route('dashboard.products') }}">Volver</a>
                <x-primary-button wire:loading.attr="disabled" wire:loading.attr="disabled">
                    Guardar
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
