<?php

namespace App\Services;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Sku;
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
            return $product->quantity * $product->price;
        });

        return $sub_total;
    }
    public static function generateOrder(Collection $orderProducts, $discountCode = null, $user): Order
    {

        $order_array = self::calculateTotal($orderProducts, $discountCode);

        return new Order([
            ...$order_array,
            'quantity' => $orderProducts->sum('quantity'),
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
            'name' => $product->name,
            'ref' => $product->ref,
            'color' => $product->color->name,
            'size' => $sku->size->name,
            'thumb' => $product->thumb,
            'old_price' => $product->old_price,
            'offer' => $product->offer,
            'price' => $product->price,
            'quantity' => $quantity,
            'total' => round($product->price * $quantity, 2),
            'product_id' => $product->id,
            'sku_id' => $sku->id,
        ];
    }

    public static function generateOrderProductsCheckout(array $products): Collection
    {
        $skuIds = array_keys($products);
        return Sku::with([
            'product' => function ($query) {
                $query->select('id', 'slug', 'name', 'ref', 'thumb', 'price', 'offer', 'old_price', 'max_quantity', 'color_id');
            }
        ])
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
