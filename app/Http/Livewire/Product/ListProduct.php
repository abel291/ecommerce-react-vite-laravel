<?php

namespace App\Http\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
	use WithPagination;
	use WithSorting;

	public $label = 'Producto';

	public $labelPlural = 'Productos';

	public $open_modal_confirmation_delete = false;

	public $category_id;

	public $categories = '';

	public function mount()
	{
		$this->categories = Category::select(['id', 'name'])->where('type', 'product')->get();
	}

	protected $queryString = ['sortBy', 'sortDirection', 'search', 'category_id'];

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
			->when($this->category_id, function (Builder $query) {
				$query->where('category_id', $this->category_id);
			})
			->withCount(['orders' => function (Builder $query) {
				$query->whereYear('orders.created_at', date('Y'));
			}])
			->orderBy($this->sortBy, $this->sortDirection)
			->paginate(20);

		return view('livewire.product.list-product', compact('list'));
	}
}
