<?php

namespace App\Services;

class OrderService
{
	public function calculate_price($product, $quantity)
	{
	}

	public static function get_total_price_products($products)
	{
	}

	public static function calculate_total_price(array|object $products, object $code_discount = null)
	{
		$sub_total = $products->sum('price_quantity');

		if ($code_discount) {
			$discount = $code_discount->only(['code', 'type', 'value']);
			$discount['applied'] = $code_discount->calculateDiscount($sub_total);
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
