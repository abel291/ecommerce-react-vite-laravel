<div x-data="{ show: false }" @modal-quantity-product.window="show = true; $wire.show($event.detail);">
    <x-modal size="sm" wire:target="show">
        <x-slot name="title">
            Order # {{ $order_code }}
        </x-slot>
        <x-slot name="content">
            <ul class="mt-4 divide-y border-t">
                @foreach ($order_products as $item)
                    @include('livewire.order.card-product', ['item' => $item])
                @endforeach

            </ul>
        </x-slot>

        <x-slot name="footer">
            <div class="text-right">
                <x-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                    Cerrar
                </x-secondary-button>
            </div>
        </x-slot>

    </x-modal>
</div>
