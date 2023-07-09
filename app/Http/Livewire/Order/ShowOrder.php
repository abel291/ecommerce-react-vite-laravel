<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;

class ShowOrder extends Component
{
    public $label = 'Pedido';

    public $labelPlural = 'Pedidos';

    public Order $order;

    public function mount($id)
    {
        $this->order = Order::with('order_products', 'order_products.product', 'payment')->find($id);
    }

    public function render()
    {
        return view('livewire.order.show-order');
    }
}
