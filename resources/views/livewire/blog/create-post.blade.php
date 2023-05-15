@section('title', $label)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>
<div>

    <form wire:submit.prevent="{{ $edit ? 'update' : 'save' }}">
        <x-content>
            <x-form.section-form title="Datos Generales">
                <x-form.grid>

                    <div class="xl:col-span-2">
                        <x-form.input-label-error wire:model.defer="post.title">Titulo</x-form.input-label-error>
                    </div>
                    <div class="lg:col-span-4">
                        <x-form.input-label-error wire:model.defer="post.slug">Url</x-form.input-label-error>
                    </div>

                    <div class="lg:col-span-2">
                        <x-form.select-active wire:model.defer="post.active" />
                    </div>
                    <div class="lg:col-span-2">
                        <x-form.select label="Categoria" wire:model.defer="post.category_id">
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                    <div class="lg:col-span-2">
                        <x-form.select label="Autor" wire:model.defer="post.author_id">
                            @foreach ($authors as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="lg:col-span-6">
                        <x-form.input-label-error wire:model.defer="post.entry">Descripcion pequeña
                        </x-form.input-label-error>
                    </div>
                    <div class="lg:col-span-6">
                        <x-form.textarea rows="4" wire:model.defer="post.desc" label="Descripcion amplia" />
                    </div>

                </x-form.grid>
            </x-form.section-form>

            <x-form.section-form title="Datos Metas">
                <x-form.grid>

                    <div class="xl:col-span-3">
                        <x-form.input-label-error wire:model.defer="post.meta_title">Meta title
                        </x-form.input-label-error>
                    </div>
                    <div class="lg:col-span-5">
                        <x-form.input-label-error wire:model.defer="post.meta_desc">Meta description
                        </x-form.input-label-error>
                    </div>
                </x-form.grid>
            </x-form.section-form>

            <x-form.section-form title="Imagenes">
                <x-form.grid>
                    <div class="lg:col-span-3">
                        <x-form.input-file :temp="$thum" model="thum" :saved="$post->thum"
                            label="Imagen miniatura" />
                    </div>
                    <div class="lg:col-span-3">
                        <x-form.input-file :temp="$img" model="img" :saved="$post->img" label="Imagen amplia" />
                    </div>
                </x-form.grid>
            </x-form.section-form>

            <div class=" flex items-center justify-end gap-x-2	">
                <a class="btn-secondary" href="{{ route('dashboard.posts') }}">Volver</a>
                <x-primary-button wire:loading.attr="disabled" x-show="edit" wire:loading.attr="disabled">
                    {{ $edit ? 'Editar' : 'Guardar' }}
                </x-primary-button>
            </div>
        </x-content>

    </form>


    {{-- @if ($edit)
        <div class="mt-10">
            <livewire:specification.list-specification :product-id="$post->id" />
        </div>
        <div class="mt-10">
            <livewire:image.list-image :model="$product" />
        </div>
    @endif --}}
</div>
