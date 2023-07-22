<?php

namespace App\Http\Livewire\Attribute;

use App\Models\Product;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListAttribute extends Component
{
	use WithPagination;
	use WithSorting;

	public $label = 'Atributo';

	public $labelPlural = 'Atributos';

	public $open_modal_confirmation_delete = false;

	protected $queryString = ['sortBy', 'sortDirection', 'search'];

	public $product;

	public function mount($id)
	{

		$this->product = Product::find($id);
	}

	protected $listeners = [
		'renderListAttributess' => 'render',
		'resetListAttribute' => 'resetList',
	];

	public function render()
	{
		$list = Product::find($this->product->id)->attributes()
			->with('attribute_values')
			->orderBy($this->sortBy, $this->sortDirection)
			->paginate(20);

		return view('livewire.attribute.list-attribute', compact('list'));
	}
}
