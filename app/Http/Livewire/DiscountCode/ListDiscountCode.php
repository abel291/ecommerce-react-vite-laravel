<?php

namespace App\Http\Livewire\DiscountCode;

use App\Models\DiscountCode;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListDiscountCode extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Codigos de descuento';

    public $labelPlural = 'Codigo de descuento';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    protected $listeners = [
        'renderListDiscountCode' => 'render',
        'resetListDiscountCode' => 'resetList',
    ];

    public function render()
    {
        $list = DiscountCode::where(function ($query) {
            $query->orWhere('code', 'like', "%$this->search%");
            $query->orWhere('name', 'like', "%$this->search%");
            $query->orWhere('value', 'like', "%$this->search%");
        })
            ->withCount('orders')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);
        //dd($list->first());
        return view('livewire.discount-code.list-discount-code', compact('list'));
    }
}
