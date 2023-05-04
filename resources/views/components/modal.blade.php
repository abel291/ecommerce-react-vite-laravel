@props(['title', 'content', 'footer', 'size' => 'lg'])
@php
    switch ($size) {
        case 'sm':
            $modalSize = 'sm:max-w-2xl md:max-w-2xl';
            break;
        case 'md':
            $modalSize = 'sm:max-w-2xl md:max-w-3xl';
            break;
        case 'lg':
        default:
            $modalSize = 'sm:max-w-2xl md:max-w-4xl';
            break;
    }
@endphp
<div>
    <div x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show"
        class="absolute top-0 inset-x-0 px-4 pt-6 sm:px-4 sm:flex sm:items-top sm:justify-center z-50"
        style="display: none;">

        <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div x-show="show" class="fixed transform transition-all sm:w-full sm:px-4 {{ $modalSize }}"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl ">


                <div class="px-7 py-7 ">
                    <div class="text-lg font-medium">
                        {{ $title }}
                    </div>

                    <div class="mt-4 content-modal relative ">
                        <div wire:loading.flex {{ $attributes->whereStartsWith('wire:target') }}>
                            <x-spinner-loading class="absolute top-2 left-2 z-10">Cargando..
                            </x-spinner-loading>
                        </div>
                        <div wire:loading.class="blur-sm" {{ $attributes->whereStartsWith('wire:target') }}>
                            {{ $content }}
                        </div>
                    </div>
                </div>


                <div class="px-6 py-4 bg-gray-100 text-right">
                    {{ $footer }}
                </div>
            </div>


        </div>
    </div>
</div>
