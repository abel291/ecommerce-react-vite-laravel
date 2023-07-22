<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;
use App\Services\CheckoutService;

class DiscountCheckoutController extends Controller
{
	public function applyDiscount(DiscountCodeRequest $request)
	{
		$discount_code = DiscountCode::select(['id', 'code', 'value', 'type'])->where('code', $request->discountCode)->firstOrFail();

		session(['discountCode' => $discount_code]);

		// CheckoutService::applyDiscount($discount_code);

		return to_route('checkout');
	}

	public function removeDiscount()
	{
		session()->forget(['discountCode']);
		return to_route('checkout');
	}
}
