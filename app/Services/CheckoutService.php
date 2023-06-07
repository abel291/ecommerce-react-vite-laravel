<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Enums\DiscountCodeTypeEnum;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class CheckoutService
{
	public static function applyDiscount(DiscountCode $discount_code): void
	{
		session(['discount_code' => $discount_code]);

		self::refreshOrder();
	}

	public static function removeDiscount(): void
	{
		session()->forget(['discount_code']);

		self::refreshOrder();
	}

	public static function refreshOrder(): void
	{
		$cart_products = session('cart_products');

		$order = self::generateOrder($cart_products);

		session(['order' => $order]);
	}

	public static function addProducts(Collection $cart_products): void
	{

		$order = self::generateOrder($cart_products);

		$cart_products = self::generateCardProducts($cart_products);

		session([
			'cart_products' => $cart_products,
			'order' => $order,
		]);
	}

	public static function generateOrder(Collection $cart_products): Order
	{
		$discount_code = session('discount_code');

		$order = OrderService::generateOrderWithsTotals($cart_products, $discount_code);

		return $order;
	}

	public static  function generateCardProducts(Collection $cart_products,): Collection
	{

		$order_products = $cart_products->map(function ($cart) {
			return  new OrderProduct([
				'name' => $cart->product->name,
				'price' => $cart->price,
				'quantity_selected' => $cart->quantity_selected,
				'price_quantity' => $cart->price_quantity,
				'product_id' => $cart->product_id,
				'data' => $cart->product->only('name', 'slug', 'img'),
			]);
		});

		return $order_products;
	}
}
