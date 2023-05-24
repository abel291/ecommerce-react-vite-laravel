<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class OrderService
{
	public static function calculatePrice(float $price, float $quantity)
	{
		return round($price * $quantity, 2);
	}

	public static function priceQuantity(Collection $products, array $quantities): Collection
	{
		$productsPricesQuantity = $products
			->map(function ($item) use ($quantities) {

				$item->quantity_selected = $quantities[$item->id];

				$item->price_quantity = self::calculatePrice($item->price_offer, $item->quantity_selected);

				$item->in_stock = $item->stock->remaining >= $item->quantity_selected;

				return $item;
			});

		return $productsPricesQuantity;
	}
	public static function productInStock(Collection $products): Collection
	{
		$productInStock = $products->filter(function ($item) {
			return $item->active && ($item->stock->remaining >= $item->quantity_selected);
		});
		return $productInStock;
	}

	public static function calculateTotalPrice(array|object $products, $discountCode = null)
	{
		$sub_total = $products->sum('price_quantity');

		if ($discountCode) {
			$discount = $discountCode->only(['code', 'type', 'value']);
			$discount['applied'] = $discountCode->calculateDiscount($sub_total);
			$new_sub_total = round($sub_total - $discount['applied'], 2);
		} else {
			$discount = null;
			$new_sub_total = $sub_total;
		}



		$tax_percent = 0.12;
		$shipping = 15000;
		$tax_amount = round($new_sub_total * $tax_percent, 2);
		$total = round($new_sub_total + $tax_amount + $shipping, 2);

		return [
			'quantity' => $products->sum('quantity_selected'),
			'sub_total' => $sub_total,
			'tax_percent' => $tax_percent,
			'tax_amount' => $tax_amount,
			'shipping' => $shipping,
			'total' => $total,
			'discount' => $discount,
		];
	}
	public static function generate_code($id): string
	{
		return  rand(10, 99) . date('md') . $id;
	}
}
