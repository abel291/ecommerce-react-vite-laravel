<?php

namespace App\Http\Livewire\Order;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ListOrder extends Component
{
	use WithPagination;
	use WithSorting;
	public $label = "Orden";
	public $labelPlural = "Ordenes";
	protected $queryString = ['sortBy', 'sortDirection', 'search', 'status'];

	public $status = null;

	protected $listeners = [
		'renderListOrder' => 'render',
		'resetListOrder' => 'resetList',
	];

	public function render()
	{
		$list = Order::where(function ($query) {
			$query->orWhere('code', 'like', "%$this->search%");
			$query->orWhere('user_data->name', 'like', "%$this->search%");
			$query->orWhere('user_data->email', 'like', "%$this->search%");
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
