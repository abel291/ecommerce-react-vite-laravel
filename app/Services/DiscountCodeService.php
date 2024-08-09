<?php

namespace App\Services;

use App\Models\DiscountCode;

class DiscountCodeService
{
    public static function IsAvailable($discountCode = null)
    {

        if (! $discountCode) {
            return $discountCode;
        }

        return DiscountCode::where('code', $discountCode)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_to', '>=', now())
            ->where('active', 1)
            ->first();
    }

    public static function applyDiscount(DiscountCode $discount_code, $order, float $amount)
    {

        $discount_code = session('discount_code');

        $discount_applied = $discount_code->calculateDiscount($order->sub_total);

        $new_sub_total = $order->sub_total - $discount_applied;

        $order->discount_id = $discount_code->id;
        $order->data = [
            'discount' => [
                ...$discount_code->only(['code', 'value', 'type']),
                'applied' => $discount_applied,
            ],
        ];
    }
}
