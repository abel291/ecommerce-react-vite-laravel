@props(['temp', 'model', 'saved' => null, 'label' => ''])

<div>
    <div class="mb-3">
        <x-input-label for="{{ $model }}">{{ $label }}</x-input-label>
        <label for="{{ $model }}">
            <div class="btn-primary w-40 cursor-pointer mt-1" wire:loading.class="opacity-50"
                wire:loading.class.remove="cursor-pointer" wire:target="{{ $model }}"">

                <span wire:loading.remove wire:target="{{ $model }}">
                    Subir Imagen
                </span>

                <span wire:loading wire:target="{{ $model }}">
                    Subiendo...
                </span>
                <input id="{{ $model }}" class="hidden" wire:target="{{ $model }}"
                    wire:loading.attr="disabled" id="{{ $model }}" type="file"
                    wire:model="{{ $model }}" accept=".png, .jpg, .jpeg">

            </div>

        </label>
        <x-input-error :model="$model" />
    </div>
    <div class="flex items-start gap-3">
        @if ($saved)
            <div class="w-full lg:w-1/2 flex justify-center">
                <img class="border rounded-md overflow-hidden" src="{{ $saved }}?{{ rand(1, 300) }}">
            </div>
        @endif
        @if ($temp)
            <div class="w-full lg:w-1/2 flex justify-center">
                <img class="border rounded-md overflow-hidden" src="{{ $temp->temporaryUrl() }}">
            </div>
        @endif
    </div>
</div>
