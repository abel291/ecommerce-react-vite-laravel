<?php

namespace App\Services;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Sku;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OrderService
{
    public static function generateCode($id): string
    {
        // $week = strtoupper(Str::slug(now()->isoFormat('dd')));
        $week = strtoupper(Str::slug(now()->subDays(rand(1, 7))->isoFormat('dd')));
        return $week . Str::padLeft($id . fake()->bothify('###'), 6, '0');
    }

    public static function subtotal($products): float
    {
        $sub_total = $products->sum(function ($product) {
            return $product->quantity * $product->price;
        });

        return $sub_total;
    }
    public static function generateOrder(Collection $order_products, $discountCode = null, $user): Order
    {

        $order_array = self::calculateTotal($order_products, $discountCode);

        return new Order([
            ...$order_array,
            'quantity' => $order_products->sum('quantity'),
            'code' => self::generateCode($user->id),
            'user_id' => $user->id,
            // 'data' => [
            //     'user' => $user->only('name', 'address', 'phone', 'email', 'city'),
            // ],
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
            $discountValue = $discountCode->calculateDiscount($subtotal);
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

        return [
            'sub_total' => $subtotal,
            'discount' => $discountCode,
            'tax_rate' => $taxRate,
            'tax_value' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }

    public static function formatOrderProduct($sku, $quantity)
    {
        $product = $sku->product;

        return [
            ...$product->only([
                'name',
                'ref',
                'thumb',
                'old_price',
                'offer',
                'price',
                'category_id',
                'department_id',
            ]),
            'color' => $product->color->name,
            'size' => $sku->size->name,
            'total' => round($product->price * $quantity, 2),
            'quantity' => $quantity,
            'sku_id' => $sku->id,
            'product_id' => $product->id,

        ];
    }

    public static function generate_order_products_checkout(array $products): Collection
    {
        $skuIds = array_keys($products);
        return Sku::with('product')
            ->find($skuIds)
            ->filter(function ($sku) use ($products) {
                return $sku->stock >= $products[$sku->id];
            })
            ->map(function ($sku) use ($products) {
                $quantity = $products[$sku->id];
                return self::formatOrderProduct($sku, $quantity);
            });
    }
}
