<div>
    <div x-data="{
        show: false,
    }" @modal-show-user.window="show = true;$wire.show($event.detail);">

        <x-modal size="md" wire:target="show">
            <x-slot name="title">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-neutral-900">Información del Usuario</h3>
                    <p class="max-w-2xl text-sm leading-6 text-neutral-500">Datos personales y direccion.</p>
                </div>
            </x-slot>
            <x-slot name="content">
                @if ($user)
                    <div class="border-t border-neutral-100">
                        <dl class="divide-y divide-neutral-100">
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Nombre Completo</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->name }}
                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Email</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->email }}
                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Telefono</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->phone }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Pais</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->country }}
                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Ciudad</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->city }}
                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Direccion</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">
                                    {{ $user->address }}
                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Fecha de registro</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">

                                    {{ $user->created_at->isoFormat('ddd DD MMM YYYY hh:mm A') }}

                                </dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-neutral-900">Fecha de modificacion</dt>
                                <dd class="mt-1 text-sm leading-6 text-neutral-700 lg:col-span-2 sm:mt-0">

                                    {{ $user->updated_at->isoFormat('ddd DD MMM YYYY hh:mm A') }}

                                </dd>
                            </div>

                        </dl>
                    </div>
                @endif

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

</div>
