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

    public static function subtotal($products): float
    {
        $sub_total = $products->sum(function ($product) {
            return $product->quantity * $product->price_offer;
        });

        return $sub_total;
    }
    public static function generateOrder($orderProducts, $discountCode = null, $user): Order
    {

        $order_array = self::calculateTotal($orderProducts, $discountCode);

        return new Order([
            ...$order_array,
            'quantity' => $orderProducts->sum('quantity'),
            'code' => self::generateCode($user->id),
            'user_id' => $orderProducts[0]['user_id'],
            'data' => [
                'user' => $user->only('name', 'address', 'phone', 'email', 'city'),
            ],
            'discount_code_id' => $discountCode?->id

        ]);
    }
    public static function calculateTotal($products, $discountCode = null): array
    {
        $subtotal = $products->sum('total');
        $taxRate = SettingService::data()['rates']['tax'];
        $shipping = (float) SettingService::data()['rates']['shipping'];
        $freeShipping = (float) SettingService::data()['rates']['freeShipping'];

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

        return  [
            'sub_total' => $subtotal,
            'discount' => $discountCode,
            'tax_rate' => $taxRate,
            'tax_value' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        ];

        return $total;
    }

    public static function formatOrderProduct($product, $quantity, $skuCode, $user)
    {
        $attributes = $product->skus->firstWhere('code', $skuCode)->attribute_values->map(function ($attribute_value) {
            return [
                'name' => $attribute_value->attribute->name,
                'value' => $attribute_value->value
            ];
        });
        return [
            'price' => $product->price_offer,
            'quantity' => $quantity,
            'total' => round($product->price_offer * $quantity),
            'data' => $product->only('id', 'name', 'slug', 'img', 'price', 'offer', 'price_offer'),
            'attributes' => $attributes,
            'user_id' => $user->id,
            'product_id' => $product->id,
        ];
    }

    // public static function createOrderWithTotalCalculation($total)
    // {

    //     return new Order([
    //         'sub_total' => $total['sub_total'],
    //         'tax_rate' => $total['tax_rate'],
    //         'tax_value' => $total['tax_value'],
    //         'shipping' => $total['shipping'],
    //         'discount' => $total['discount'],
    //         'total' => $total['total'],
    //         'discount_code_id' => $total['discount'] ? $total['discount']['id'] : null,
    //     ]);
    // }
}
