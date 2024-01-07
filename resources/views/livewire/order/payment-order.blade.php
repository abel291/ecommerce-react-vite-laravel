<div>
    <x-form.title>Datos de pago</x-form.title>
    <dl class=" divide-y divide-neutral-100">

        <x-list-description title="Codigo" :desc="$order->code">
            <x-slot:title>Methodo de pago</x-slot:title>
            <x-slot:desc>{{ $order->payment->method->text() }}</x-slot:desc>
        </x-list-description>

        <x-list-description title="Codigo" :desc="$order->code">
            <x-slot:title>Estado</x-slot:title>
            <x-slot:desc>
                <x-badge class="capitalize" :color="$order->payment->status->color()">
                    {{ $order->payment->status->text() }}
                </x-badge>
            </x-slot:desc>
        </x-list-description>

        <x-list-description title="Codigo" :desc="$order->code">
            <x-slot:title>Referencia</x-slot:title>
            <x-slot:desc>
                @if ($order->payment->reference)
                    {{ $order->payment->reference }}
                @else
                    <span class="text-neutral-500 ">sin referencia</span>
                @endif
            </x-slot:desc>
        </x-list-description>
        <div class="text-right mt-8">
            @if ($order->payment->canCancel())
                <button class="text-red-600 hover:text-red-700 font-medium text-sm" type="button" x-data
                    ::key="status_ + {{ $order->id }}"
                    x-on:click="$dispatch('modal-status-canceled',{{ $order->payment->id }})">
                    Cancelar Orden
                </button>
            @endif
        </div>
    </dl>

    @include('livewire.order.modal-canceled', ['order_id' => $order->id, 'amount' => $order->total])
</div>
