<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;

class CartService
{
	public static function generateId($product, $attributes)
	{
		return $product->id;
	}


	public static function add(string $keySession, object $product, int $quantity = 1, array $options = []): void
	{

		Cart::instance($keySession)->add([
			'id' => self::generateId($product, $options['attributes']),
			'name' => $product->name,
			'price' => $product->price_offer,
			'qty' => $quantity,
			'options' => $options
		])->associate($product);
	}

	public static function formatAttributes($attributes)
	{
		$newAttributes = [];

		if ($attributes) {
			foreach ($attributes as $attribute_name => $attribute_value) {
				$newAttributes[] = [
					'name' => $attribute_name,
					'value' => $attribute_value,
				];
			}
		}

		return $newAttributes;
	}
}
