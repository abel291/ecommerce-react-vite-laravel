<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class PaymentService
{
	public static  function refund($order)
	{
		$user = $order->user;
		//dd($user);
		$user->refund($order->payment->reference);
	}

	public static  function charger(User $user, Order $order, string $payment_method_id): object
	{
		return  $user->charge($order->total * 100, $payment_method_id, [
			'metadata' => [
				'order_code' => $order->code,
				'quantity_products' => $order->quantity
			],
			'description' => "Compra Por internet $order->code - $user->email"
		]);
	}
}
