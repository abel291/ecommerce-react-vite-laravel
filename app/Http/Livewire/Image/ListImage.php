<?php

namespace App\Http\Livewire\Image;

use App\Models\Page;
use App\Models\Product;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListImage extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Imagen';

    public $labelPlural = 'Imagenes';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    public $modelData;

    public $modelName;

    public $modelId;

    public $listModel = [
        'product' => Product::class,
        'page' => Page::class,
    ];

    public function mount($name, $id)
    {
        $this->modelData = $this->listModel[$name]::find($id);
        $this->modelName = $this->listModel[$name];
        $this->modelId = $id;
    }

    protected $listeners = [
        'renderListImage' => 'render',
        'resetListImage' => 'resetList',
    ];

    public function render()
    {

        $list = $this->modelData->images()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.image.list-image', compact('list'));
    }
}
