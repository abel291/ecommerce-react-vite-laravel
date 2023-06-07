@section('title', $labelPlural)
<x-slot name="header">
    {{ $labelPlural }}
</x-slot>

<div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-2 my-4">
        <x-form.input-search />
        <div>
            <a class="btn-primary block h-full justify-center shadow-sm" href="{{ route('dashboard.posts-create') }}">
                Crear {{ $label }}
            </a>
        </div>
    </div>

    <x-content>
        <x-table.table :data="$list" wire:target="delete,search">
            <thead>
                <tr>
                    @php
                        $tableNamesHead = [
                            'name' => 'Nombre',
                            'meta_title' => 'Titulo',
                            'meta_desc' => 'Descripcion',
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
                            <x-table.title-image :img="$item->img" :title="$item->title" :sub-title="$item->author->name"
                                :path="route('blog', $item->slug)" />
                        </td>
                        <td>
                            <x-badge color="indigo">{{ $item->category->name }}</x-badge>
                        </td>

                        <td>
                            <x-badge-active :active="$item->active" />
                        </td>

                        <td>
                            <x-date-format :date="$item->updated_at" />
                        </td>

                        <td>
                            <x-table.button-options>
                                <x-table.button :path="route('dashboard.posts-edit', $item->id)">Editar</x-table.button>
                                <x-table.button-delete :id="$item->id" />
                            </x-table.button-options>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </x-table.table>
    </x-content>

    <x-modal-confirmation-delete />
</div>
