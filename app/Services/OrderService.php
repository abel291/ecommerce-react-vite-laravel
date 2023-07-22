<?php

namespace App\Services;

use App\Models\DiscountCode;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;

class OrderService
{

	public static function generateCode($id): string
	{
		return date('md') . str_pad(Mt_rand(1, 1000), 4, 0) . $id;
	}

	public static function calculateTotal($subtotal, $discountCode = null): array
	{

		$taxRate = SettingService::data()['rates']['tax'];
		$shipping = (float)	SettingService::data()['rates']['shipping'];
		$freeShipping = (float)	SettingService::data()['rates']['freeShipping'];

		if ($discountCode) {
			$discountValue =  $discountCode->calculateDiscount($subtotal);
			$discountCode->applied = $discountValue;
		} else {
			$discountValue = 0;
		}

		$subtotalWithDiscount = round($subtotal - $discountValue, 2);

		$tax = round($subtotalWithDiscount * ($taxRate / 100), 2);

		$subtotalWithTaxes = ($subtotalWithDiscount + $tax);

		if ($subtotalWithTaxes > $freeShipping) {
			$shipping = 0;
		}

		$total = round($subtotalWithTaxes + $shipping, 2);

		$total = [
			'subtotal' => $subtotal,
			'discount' => $discountCode,
			'tax' => [
				'rate' => $taxRate,
				'value' => $tax
			],
			'shipping' => $shipping,
			'total' => $total,
		];

		return $total;
	}
	public static function createOrderProduct($products, $quantity)
	{
	}

	public static function createOrderWithTotalCalculation($total)
	{

		return new Order([
			'sub_total' => $total['subtotal'],
			'tax' => $total['tax'],
			'shipping' => $total['shipping'],
			'discount' => $total['discount'],
			'total' => $total['total'],
			'discount_code_id' => $total['discount'] ? $total['discount']['id'] : null,
		]);
	}
}
