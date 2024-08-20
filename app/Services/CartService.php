<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Presentation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CartService
{

    public static function session($keySession = CartEnum::SHOPPING_CART): array
    {
        return session($keySession->value, []);
    }

    public static function add(CartEnum $cardType, $product_id, $code_presentation, $quantity): void
    {

        $sessionProducts = self::session($cardType);

        $sessionProducts[$code_presentation] = [
            'product_id' => $product_id,
            'code_presentation' => $code_presentation,
            'quantity' => $quantity,
        ];


        session([$cardType->value => $sessionProducts]);
    }
    public static function products(CartEnum $cardEnum = CartEnum::SHOPPING_CART): Collection
    {

        $sessionProducts = collect(self::session($cardEnum));

        $products_id = $sessionProducts->pluck('product_id')->toArray();

        $codes_presentation = $sessionProducts->pluck('code_presentation')->toArray();



        $selectProduct = ['id', 'name', 'slug', 'thumb', 'price', 'offer', 'old_price', 'max_quantity'];
        $products = Product::select($selectProduct)
            ->active()
            ->withWhereHas('presentations', function ($query) use ($codes_presentation) {
                $query->where('stock', '>', 0)
                    ->whereIn('code', $codes_presentation)
                    ->with('color:id,name', 'size:id,name');
            })->find($products_id)->map(function ($product) use ($sessionProducts, $selectProduct) {

                $presentation = $product->presentations[0];
                $quantity = $sessionProducts[$presentation->code]['quantity'];
                return [
                    ...$product->only($selectProduct),
                    'quantity' => $quantity,
                    'total' => round($product->price * $quantity),
                    'presentation' => $presentation->only(['id', 'name', 'code', 'stock', 'color', 'size'])
                ];
            });

        return $products;
    }


    // public static function update(string $keySession, string $rowId, int $quantity = 1): void
    // {
    //     $products = self::session($keySession);

    //     $products = self::changeTotalProduct($products, $rowId, $quantity);

    //     session([$keySession => $products]);
    // }

    public static function remove(CartEnum $cardEnum, int $codePresentation): void
    {
        $products = self::session($cardEnum);

        unset($products[$codePresentation]);

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
