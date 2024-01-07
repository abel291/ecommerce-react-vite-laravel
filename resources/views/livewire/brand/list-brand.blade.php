@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 my-4">
        <x-form.input-search />
        <div>
            <x-primary-button type="button" x-data=""
                class="btn-primary block h-full justify-center shadow-sm" x-on:click="$dispatch('modal-create')">
                Agregar {{ $label }}
            </x-primary-button>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="search">
            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'name' => 'Nombre',
                            'website' => 'Website',
                            //'entry' => 'Descipcion',
                            'active' => 'Visible',
                            'updated_at' => 'Ultima actualización',
                        ];
                    @endphp

                    @foreach ($tableNamesHead as $key => $name)
                        <x-table.th :name="$name" />
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="text-sm">

                        <td class="whitespace-nowrap">
                            <x-table.title-image :img="$item->img" :title="$item->name" :sub-title="$item->slug"
                                :path="route('search', ['brands[]' => $item->slug])" />
                        </td>

                        <td class="max-w-md">
                            <a target="_blank" href="{{ $item->website }}">{{ $item->website }}</a>
                        </td>

                        <td class="text-neutral-500 font-medium ">

                            <x-badge-active :active="$item->active" />
                        </td>

                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button :id="$item->id" modal-id="modal-edit">Editar</x-table.button>
                                <x-table.button-delete :id="$item->id" />
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>
    <livewire:brand.create-brand :label="$label" :label-plural="$labelPlural" />

</div>
