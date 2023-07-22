<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListOrder extends Component
{
	use WithPagination;
	use WithSorting;

	public $label = 'Orden';

	public $labelPlural = 'Ordenes';

	public $status = '';

	protected $queryString = ['sortBy', 'sortDirection', 'search', 'status'];

	protected $listeners = [
		'renderListOrder' => 'render',
		'resetListOrder' => 'resetList',
	];

	public function render()
	{
		$list = Order::where(function ($query) {
			$query->orWhere('code', 'like', "%$this->search%");
			$query->orWhere('data->user->name', 'like', "%$this->search%");
			$query->orWhere('data->user->email', 'like', "%$this->search%");
		})
			->when($this->status, function (Builder $query) {
				$query->whereHas('payment', function (Builder $sub_query) {
					$sub_query->where('status', $this->status);
				});
			})
			->with('payment', 'order_products')
			->orderBy($this->sortBy, $this->sortDirection)
			->paginate(20);

		return view('livewire.order.list-order', compact('list'));
	}
}
