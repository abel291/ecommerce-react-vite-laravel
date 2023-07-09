<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class ViewProduct extends Component
{
    public $order_code = null;

    public $order_products = [];

    public function show($order_id)
    {
        $order = Order::with('order_products.product')->find($order_id);
        $this->order_code = $order->code;
        $this->order_products = $order->order_products;
    }

    public function render()
    {
        return view('livewire.order.view-product');
    }
}
