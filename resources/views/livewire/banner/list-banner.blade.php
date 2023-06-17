@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row  md:items-end gap-2 my-4">
        <x-form.input-search />
        <x-form.select wire:model="pages_id" label="Paginas">
            @foreach ($pages_list as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </x-form.select>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="delete,search">
            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'img' => 'Imagen',
                            'position' => 'Posicion',
                            'active' => 'Activo',
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
                            <x-table.title-image :img="$item->img" :title="$item->model->title" />
                        </td>
                        <td>
                            <x-badge color="gray">{{ $item->position }}</x-badge>
                        </td>

                        <td>
                            <x-badge-active :active="$item->active" />
                        </td>

                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button :id="$item->id" modal-id="modal-edit">Editar</x-table.button>
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>
    <livewire:banner.create-banner :label="$label" :label-plural="$labelPlural" />

</div>
