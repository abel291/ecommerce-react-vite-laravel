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

	public static function calculate_total_price(float $amount)
	{
		$tax_percent = 0.12;
		$shipping = 11;
		$sub_total = $amount;
		$tax_amount = round($sub_total * $tax_percent, 2);
		$total = round($sub_total + $tax_amount + $shipping, 2);

		return [
			'sub_total' => $sub_total,
			'tax_percent' => $tax_percent,
			'tax_amount' => $tax_amount,
			'shipping' => $shipping,
			'total' => $total,
		];
	}

	public static function generate_code(): string
	{
		return  rand(1000, 9999) . date('md') . auth()->user()->id;
	}
}
