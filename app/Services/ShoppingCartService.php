<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class ShoppingCartService
{
	public static function addProduct(object $user, object $product, int $quantity = 1): void
	{

		$product_in_shopping_cart = $user->shopping_cart()->where('product_id', $product->id)->first();

		$price_quantity = OrderService::calculatePrice($product->price_offer, $quantity);

		if ($product_in_shopping_cart) {

			$product_in_shopping_cart->pivot->quantity = $quantity;
			$product_in_shopping_cart->pivot->price_quantity = $price_quantity;
			$product_in_shopping_cart->pivot->save();
		} else {
			$user->shopping_cart()->attach($product->id, [
				'quantity' => $quantity,
				'price_quantity' => $price_quantity
			]);
		}
	}
}
