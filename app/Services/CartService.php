<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Presentation;
use App\Models\Product;
use App\Models\Sku;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CartService
{

    public static function session($keySession = CartEnum::SHOPPING_CART): array
    {
        return session($keySession->value, []);
    }

    public static function add(CartEnum $cardType, $skuId, $quantity): void
    {

        $sessionProducts = self::session($cardType);

        if ($quantity == 0) {
            unset($sessionProducts[$skuId]);
        } else {
            $sessionProducts[$skuId] = $quantity;
        }


        session([$cardType->value => $sessionProducts]);
    }
    public static function products(CartEnum $cardEnum = CartEnum::SHOPPING_CART): Collection
    {

        $skuIdQuantity = self::session($cardEnum);
        $skusId = array_keys($skuIdQuantity);

        $selectProduct = ['id', 'name', 'thumb', 'slug', 'ref', 'price', 'offer', 'old_price', 'max_quantity', 'color_id'];

        $products = Sku::where('stock', '>', 0)
            ->whereIn('id', $skusId)
            ->with('size:id,name')
            ->withWhereHas('product', function ($query) use ($selectProduct) {
                $query->select($selectProduct)->with('color:id,name,slug');
            })
            ->get()
            ->map(function ($sku) use ($skuIdQuantity, $selectProduct) {

                $quantity = $skuIdQuantity[$sku->id];
                return [
                    ...$sku->product->toArray(),
                    'skuId' => $sku->id,
                    'stock' => $sku->stock,
                    'quantity' => $quantity,
                    'total' => round($sku->product->price * $quantity),
                    'size' => $sku->size->only(['id', 'name']),
                    'color' => $sku->product->color->only(['id', 'name']),
                    'thumb' => $sku->product->thumb,
                ];
            });
        ;

        return $products;
    }

    public static function remove(CartEnum $cardEnum, int $skuId): void
    {
        $products = self::session($cardEnum);

        unset($products[$skuId]);

        session([$cardEnum->value => $products]);
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
