<?php

namespace App\Services;

use App\Models\DiscountCode;
use App\Models\Product;

class DiscountCodeService
{
	public  static function IsAvailable($discountCode = null)
	{

		if (!$discountCode) {
			return $discountCode;
		}
		return DiscountCode::where('code', $discountCode)
			->whereDate('start_date', '<=', now())
			->whereDate('end_date', '>=', now())
			->where('active', 1)
			->first();
	}
}
