<?php

namespace App\Http\Livewire\Specification;

use App\Models\Product;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListSpecification extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Especificación';

    public $labelPlural = 'Especificaciones';

    public $open_modal_confirmation_delete = false;

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    public $product;

    public function mount($id)
    {
        $this->product = Product::find($id);
    }

    protected $listeners = [
        'renderListSpecification' => 'render',
        'resetListSpecification' => 'resetList',
    ];

    public function render()
    {
        $list = $this->product->specifications()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.specification.list-specification', compact('list'));
    }
}
