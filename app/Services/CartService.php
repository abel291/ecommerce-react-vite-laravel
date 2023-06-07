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

class CartService
{

	public function addProduct(object $user, object $product, int $quantity_selected = 1, $type = CartEnum::SHOPPIN_CART): void
	{
		$user->shoppingCart()->updateOrCreate(
			[
				'product_id' => $product->id,
			],
			[
				'name' => $product->name,
				'type' => $type,
				'quantity_selected' => $quantity_selected,
				'price' => $product->price_offer,
				'price_quantity' => self::calculatePrice($product->price_offer, $quantity_selected)
			]
		);
	}

	public static function productsInStock(Collection $cart): Collection
	{
		$cart_products_in_stock = $cart->filter(function ($cart) {
			return $cart->product->active && ($cart->product->stock->remaining >= $cart->quantity_selected);
		});

		return $cart_products_in_stock;
	}

	public static function calculatePrice(float $price, int $quantity)
	{
		return round($price * $quantity, 2);
	}

	public static function generateCartProduct(Product $product, int $quantity)
	{
		$cart_product = new OrderProduct([
			'name' => $product->name,
			'price' => $product->price_offer,
			'quantity_selected' => $quantity,
			'price_quantity' => self::calculatePrice($product->price_offer,  $quantity),
			'data' => $product->only('name', 'slug', 'img'),
			'product_id' => $product->id

		]);

		return $cart_product;
	}
}
