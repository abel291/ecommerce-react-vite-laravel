<?php

namespace App\Contracts;

use App\Models\DiscountCode;
use Illuminate\Support\Collection;

interface CheckoutInterface
{
    public static function applyDiscount(DiscountCode $discount_code): void;

    public static function removeDiscount(): void;

    public static function refreshPriceOrder(): void;

    public static function addProducts(Collection $cart_products): void;
}
