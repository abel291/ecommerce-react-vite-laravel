<x-modal-create>
    <x-modal size="md" wire:target="create,edit,save">
        <x-slot name="title">
            {{ $label }}
        </x-slot>
        <x-slot name="content">
            <x-form.grid>
                <div class="lg:col-span-3">
                    <x-form.input-label-error wire:model.defer="image.alt">Alt</x-form.input-label-error>
                </div>
                <div class="lg:col-span-3">
                    <x-form.input-label-error wire:model.defer="image.title">Titulo</x-form.input-label-error>
                </div>
                <div class="lg:col-span-2">
                    <x-form.select-active wire:model.defer="image.active" />
                </div>
                <div class="lg:col-span-2">
                    <x-form.input-label-error type="number" wire:model.defer="image.sort">Orden
                    </x-form.input-label-error>
                </div>
                <div class="lg:col-span-2"></div>

                @switch($modelName)
                    @case('App\Models\Blog')
                        @include('livewire.image.form-image-page')
                    @break
                @endswitch

                <div class="lg:col-span-3">
                    <x-form.input-file :temp="$img" model="img" :saved="$image->img" label="Imagen amplia" />
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
