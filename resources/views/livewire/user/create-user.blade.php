<div>
    <div x-data="{
        show: @entangle('open').defer,
        edit: false,
    }" @modal-edit-user.window="show = true; edit= true; $wire.edit($event.detail);"
        @modal-create-user.window="show = true; edit= false; $wire.create();">

        <x-modal size="md" wire:target="create,edit,save,update">
            <x-slot name="title">
                {{ $label }}
            </x-slot>
            <x-slot name="content">

                <div class="grid grid-cols-1 md:grid-cols-6 gap-x-6 gap-y-8">

                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="user.name">Nombre</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="user.phone">Telefono</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-4">
                        <x-form.input-label-error wire:model.defer="user.email">Email</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="user.country">Pais</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error wire:model.defer="user.city">Ciudad</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-6">
                        <x-form.input-label-error wire:model.defer="user.address">Direccion</x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-6">
                        <x-input-label>Roles</x-input-label>
                        <x-form.select wire:model.defer="role" class="capitalize">
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </x-form.select>
                        <x-input-error model="role" />
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error type="password" wire:model.defer="password">Contraseña
                        </x-form.input-label-error>
                    </div>
                    <div class="sm:col-span-3">
                        <x-form.input-label-error type="password" wire:model.defer="password_confirmation">Confirmar
                            Contraseña
                        </x-form.input-label-error>
                    </div>


                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="text-right">

                    <x-secondary-button x-on:click="show=false" wire:loading.attr="disabled">
                        Cerrar
                    </x-secondary-button>

                    <x-primary-button x-show="edit" class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        Editar
                    </x-primary-button>

                    <x-primary-button x-show="!edit" type="button" class="ml-2" x-on:click="$wire.save"
                        wire:loading.attr="disabled">
                        Guardar
                    </x-primary-button>

                </div>
            </x-slot>
        </x-modal>
    </div>
    <!--Modal confirmation delete-->
    <x-modal-confirmation-delete />
</div>
