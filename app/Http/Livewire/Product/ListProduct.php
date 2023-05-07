<?php

namespace App\Http\Livewire\Product;

use App\Models\Image;
use App\Models\Product;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
	use WithPagination;
	use WithSorting;
	public $label = "Producto";
	public $labelPlural = "Productos";
	public $open_modal_confirmation_delete = false;
	protected $queryString = ['sortBy', 'sortDirection', 'search'];
	protected $listeners = [
		'renderListProduct' => 'render',
		'resetListProduct' => 'resetList',
	];

	public function delete(Product $product)
	{
		$name = $product->name;
		$product->images()->delete();
		$product->delete();

		$this->open_modal_confirmation_delete = false;
		$this->emit('renderListProduct');
		$this->dispatchBrowserEvent('notification', [
			'title' => 'Regsitro Eliminado',
			'subtitle' => 'El registro  <b>' . $name . '</b>  fue quitado de la lista',
		]);
	}

	public function render()
	{
		$list = Product::with('category', 'stock')->where(function ($query) {
			$query->orWhere('name', 'like', "%$this->search%");
			$query->orWhere('description_min', 'like', "%$this->search%");
			$query->orWhere('description_max', 'like', "%$this->search%");
		})
			->withCount(['orders' => function (Builder $query) {
				$query->whereYear('created_at', date('Y'));
			}])
			->orderBy($this->sortBy, $this->sortDirection)
			->paginate(20);

		//dd($list->first()->stock);
		return view('livewire.product.list-product', compact('list'));
	}
}
