<div>
    <div x-data="{
        show: @entangle('open').defer,
        id: null
    }" @modal-status-success.window="show = true;">
        <x-modal wire:target="" size="sm">
            <x-slot name="title">
                Aprobar Pago
            </x-slot>
            <x-slot name="content">

                <form action="">
                    <x-form.grid>
                        <div class="lg:col-span-3">
                            <x-form.input-label-error wire:model.defer="code_reference">Referencia de pago
                            </x-form.input-label-error>
                        </div>
                    </x-form.grid>
                </form>

            </x-slot>
            <x-slot name="footer">
                <x-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ml-2" x-on:click="$wire.approvePayment()" wire:loading.attr="disabled">
                    <span wire:loading.class="hidden" wire:target="approvePayment">Aprobar Pago</span>
                    <span wire:loading wire:target="approvePayment"> Aprobando... </span>
                    </x-danger-button>
            </x-slot>
        </x-modal>
    </div>
</div>
