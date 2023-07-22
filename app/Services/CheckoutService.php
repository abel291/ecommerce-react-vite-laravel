<?php

namespace App\Services;

use App\Contracts\CheckoutInterface;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Collection;

class CheckoutService implements CheckoutInterface
{
	public static function applyDiscount(DiscountCode $discount_code): void
	{
		session(['discountCode' => $discount_code]);
	}

	public static function removeDiscount(): void
	{
		session()->forget(['discount_code']);
	}

	public static function refreshPriceOrder(): void
	{
		$cart_products = session('cart_products');

		$order = self::generateOrder($cart_products);

		session(['order' => $order]);
	}

	public static function addProducts(Collection $cart_products): void
	{
		$cart_products = $cart_products->map(function ($cart_product) {
			return new OrderProduct([
				'name' => $cart_product->product->name,
				'price' => $cart_product->price,
				'quantity_selected' => $cart_product->quantity_selected,
				'price_quantity' => $cart_product->price_quantity,
				'product_id' => $cart_product->product_id,
				'data' => $cart_product->product->only('name', 'slug', 'img'),
			]);
		});

		$order = self::generateOrder($cart_products);

		session([
			'cart_products' => $cart_products,
			'order' => $order,
		]);
	}

	public static function generateOrder(Collection $cart_products): Order
	{
		$discount_code = session('discount_code');

		$order = OrderService::calculateTotals($cart_products, $discount_code);

		return $order;
	}
}
