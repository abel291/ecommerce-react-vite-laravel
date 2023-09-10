@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>

    <form wire:submit.prevent="update">

        <div class="mt-5">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 ">
                <div class="lg:col-span-7">
                    <x-card title="Ajustes Generales">

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
                                    label="Frase" />
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

                    </x-card>
                </div>
                <div class="lg:col-span-5">
                    <x-card title="Tarifas">

                        <x-form.grid>
                            <div class="lg:col-span-4">
                                <x-form.input-group text="%" label="Impuestos" type="number" min="0"
                                    max="100" wire:model.defer="settings.rates.tax" />
                            </div>

                            <div class="lg:col-span-4">
                                <x-form.input-group text="$" label="Valor del envio" type="number" min="0"
                                    wire:model.defer="settings.rates.shipping" />
                            </div>

                            <div class="lg:col-span-4">
                                <x-form.input-group text="$" label="Monto minimo para envio gratis" type="number"
                                    min="0" wire:model.defer="settings.rates.freeShipping" />
                            </div>


                        </x-form.grid>
                    </x-card>
                    <x-card class="mt-5" title="Redes">

                        <x-form.grid>
                            <div class="lg:col-span-6">
                                <x-form.input-label-error label="" max="100"
                                    wire:model.defer="settings.social.facebook">
                                    Facebbok
                                </x-form.input-label-error>
                            </div>

                            <div class="lg:col-span-6">
                                <x-form.input-label-error label="" wire:model.defer="settings.social.twitter">
                                    Twitter
                                </x-form.input-label-error>
                            </div>

                            <div class="lg:col-span-6">
                                <x-form.input-label-error label="" max="100"
                                    wire:model.defer="settings.social.instagram">
                                    Instragram
                                </x-form.input-label-error>
                            </div>

                            <div class="lg:col-span-6">
                                <x-form.input-label-error label="" wire:model.defer="settings.social.ws">
                                    WhatsApp
                                </x-form.input-label-error>
                            </div>

                        </x-form.grid>
                    </x-card>
                </div>

            </div>

        </div>
        <div class=" flex items-center justify-end gap-x-2 mt-5	">
            <a class="btn-secondary" href="{{ route('dashboard.products') }}">Volver</a>
            <x-primary-button wire:loading.attr="disabled" wire:loading.attr="disabled">
                Guardar
            </x-primary-button>
        </div>



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
