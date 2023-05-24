<div>
    <x-modal-create>

        <x-modal size="md" wire:target="create,edit,save">
            <x-slot name="title">
                {{ $label }}
            </x-slot>
            <x-slot name="content">
                <x-form.grid>
                    <div class="lg:col-span-3">
                        <x-form.input-label-error class="uppercase" wire:model.defer="discountCode.code">
                            Codigo
                        </x-form.input-label-error>
                    </div>

                    <div class="lg:col-span-3">
                        <x-form.select wire:model.defer="discountCode.value" label="Porcentaje de Descuento">
                            @for ($i = 1; $i < 19; $i++)
                                <option value="{{ $i * 5 }}">{{ $i * 5 }}%</option>
                            @endfor


                        </x-form.select>

                    </div>

                    <div class="lg:col-span-3">
                        <x-form.input-label-error wire:model.defer="discountCode.name">
                            Nombre
                        </x-form.input-label-error>
                    </div>
                    <div class="lg:col-span-2">
                        <x-form.select-active wire:model.defer="discountCode.active" />
                    </div>

                    <div class="lg:col-span-6">
                        <x-form.input-label-error wire:model.defer="discountCode.entry">
                            Pequeña descripcion
                        </x-form.input-label-error>
                    </div>
                    {{-- x-data="{
                        start_date: @entangle('discountCode.start_date').defer,
                        end_date: @entangle('discountCode.end_date').defer
                    }" --}}
                    <div class="lg:col-span-3">
                        <x-form.input-date wire:model.defer="discountCode.start_date">
                            Fecha de inicio
                        </x-form.input-date>

                    </div>

                    <div class="lg:col-span-3">
                        <x-form.input-date wire:model.defer="discountCode.end_date">
                            Fecha de final
                        </x-form.input-date>
                    </div>

                </x-form.grid>
            </x-slot>
            <x-slot name="footer">
                <div class="text-right">
                    <x-form.button-modal-save />
                </div>
            </x-slot>
        </x-modal>

    </x-modal-create>
    <x-modal-confirmation-delete />
</div>
@push('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
@endpush
