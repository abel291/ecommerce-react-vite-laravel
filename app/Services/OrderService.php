<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class OrderService
{
	public static function generateCode($id): string
	{
		return  rand(100, 999) . date('mds') . $id;
	}

	public static function subTotal(Collection $cart_products): float
	{
		return round($cart_products->sum('price_quantity'), 2);
	}

	public static  function generateOrderWithsTotals(Collection $cart_products, DiscountCode $discount_code = null): Order
	{
		$tax_percent = 12;

		$shipping = 8;

		$order = new Order();

		$order->sub_total = self::subTotal($cart_products);
		$order->quantity = $cart_products->sum('quantity_selected');

		if ($discount_code) {

			$discount_applied = $discount_code->calculateDiscount($order->sub_total);

			$order->discount_code_id = $discount_code->id;
			$order->discount = [
				...$discount_code->only(['code', 'value', 'type']),
				'applied' => $discount_applied
			];
		} else {
			$discount_applied = 0;
		}

		$order->shipping = $shipping;

		$order->tax_percent = $tax_percent;

		$order->tax_amount = self::calculateTax($order->sub_total);

		$order->total = round(($order->sub_total + $order->tax_amount + $shipping) - $discount_applied, 2);

		return $order;
	}

	public static  function calculateTax(float $sub_total): float
	{
		$tax_percent = 12;

		return  round($sub_total * ($tax_percent / 100), 2);
	}
}
