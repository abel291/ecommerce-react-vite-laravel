<?php

namespace App\Http\Livewire\Order;

use App\Models\OrderProduct;
use Livewire\Component;

class ViewProduct extends Component
{
	public $order_products = [];

	public function show($order_id)
	{
		$this->order_products = OrderProduct::with('product')->where('order_id', $order_id)->get();
	}
	public function render()
	{
		return view('livewire.order.view-product');
	}
}
