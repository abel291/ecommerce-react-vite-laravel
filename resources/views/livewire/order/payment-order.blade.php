<div>
    <x-content>
        <x-form.title>Datos de pago</x-form.title>
        <dl class="font-medium text-sm pt-4 space-y-4 border-t">
            <div class="flex justify-between">
                <dt class="text-gray-500">Methodo de pago</dt>
                <dd class="text-gray-900 ">{{ $order->payment->method->text() }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Estado</dt>
                <dd>
                    <x-badge class="capitalize" :color="$order->payment->status->color()">
                        {{ $order->payment->status->text() }}
                    </x-badge>
                </dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-gray-500">Referencia de pago</dt>
                <dd>

                    @if ($order->payment->status == \App\Enums\PaymentStatus::PENDING)
                        <span class="text-gray-500 ">sin referencia</span>
                    @else
                        {{ $order->payment->reference }}
                    @endif
                </dd>
            </div>

        </dl>
        <div class="text-right mt-8">
            @if ($order->payment->status == \App\Enums\PaymentStatus::PENDING)
                <x-primary-button type="button" x-data ::key="status_ + {{ $order->id }}"
                    x-on:click="$dispatch('modal-status-success',{{ $order->payment->id }})">
                    Registrar referencia pago
                </x-primary-button>
            @endif
            @if ($order->payment->status == \App\Enums\PaymentStatus::SUCCESSFUL)
                <x-danger-button type="button" x-data ::key="status_ + {{ $order->id }}"
                    x-on:click="$dispatch('modal-status-canceled',{{ $order->payment->id }})">
                    Cancelar Orden
                </x-danger-button>
            @endif
        </div>
    </x-content>
    @include('livewire.order.modal-status')
    @include('livewire.order.modal-canceled')
</div>
