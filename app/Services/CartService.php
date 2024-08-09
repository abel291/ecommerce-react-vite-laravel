<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CartService
{

    public static function session($keySession)
    {
        return session($keySession, collect([]));
    }

    public static function generateRowId($product, $attributes = [])
    {
        $rowId = $product->id;
        foreach ($attributes as $name => $value) {
            $rowId .= Str::slug($name . $value, '');
        }
        return $rowId;
    }

    public static function total_price_quantity($amount, $quantity)
    {
        return round($amount * $quantity, 2);
    }


    public static function add(string $keySession, object $product, int $quantity = 1, array $attributes = []): void
    {

        $products = self::session($keySession);

        $rowId = self::generateRowId($product, $attributes);

        $productExist = $products->firstWhere('rowId', $rowId);

        if ($productExist) {
            $products = self::changeTotalProduct($products, $rowId, $quantity);
        } else {
            $product = [
                'rowId' => $rowId,
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'img' => $product->img,
                'price' => $product->price,
                'price_offer' => $product->price_offer,
                'quantity' => $quantity,
                'max_quantity' => min($product->max_quantity, $product->stock->remaining),
                'total' => self::total_price_quantity($product->price_offer, $quantity),
                'attributes' => self::formatAttributes($attributes)
            ];

            $products->push($product);
        }

        session([$keySession => $products]);
    }
    public static function changeTotalProduct($products, string $rowId, int $quantity)
    {

        $products = $products->map(function ($productInCart) use ($rowId, $quantity) {
            if ($productInCart['rowId'] == $rowId) {
                $productInCart['quantity'] = $quantity;
                $productInCart['total'] = self::total_price_quantity($productInCart['price_offer'], $quantity);
            }
            return $productInCart;
        });
        return $products;
    }

    public static function update(string $keySession, string $rowId, int $quantity = 1): void
    {
        $products = self::session($keySession);

        $products = self::changeTotalProduct($products, $rowId, $quantity);

        session([$keySession => $products]);
    }

    public static function remove(string $keySession, string $rowId): void
    {
        $products = self::session($keySession);

        $products = $products = $products->filter(function ($product) use ($rowId) {
            return $product['rowId'] != $rowId;
        });

        session([$keySession => $products]);
    }

    public static function formatAttributes($attributes)
    {
        $newAttributes = [];

        if ($attributes) {
            foreach ($attributes as $attribute_name => $attribute_value) {
                $newAttributes[] = [
                    'name' => $attribute_name,
                    'value' => $attribute_value,
                ];
            }
        }

        return $newAttributes;
    }
}
