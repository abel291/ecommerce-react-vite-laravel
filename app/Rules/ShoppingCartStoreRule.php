<?php

namespace App\Rules;

use App\Enums\CartEnum;
use App\Models\Presentation;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Variant;
use App\Services\CartService;
use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ShoppingCartStoreRule implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $quantity = $this->data['quantity'];
        $skuId = $this->data['skuId'];

        $product = Product::select('id', 'max_quantity')
            ->whereRelation('variant', 'active', '=', 1)
            ->whereHas('skus', function ($query) use ($skuId) {
                $query->where('id', $skuId);
            })->first();

        $sku = Sku::with('product:id,max_quantity')->find($skuId);

        $max_items = config('shopping-cart.max-quantity');

        $cart = CartService::session();

        if (count($cart) >= $max_items) {
            $fail("Carrito lleno! ,no puedes tener mas de $max_items productos en el carritos");
        }

        if ($quantity > $product->max_quantity) {
            $fail("La cantidad maxima que puedes llevar de este producto es de:  $product->max_quantity  unidade(s)");
        }

        if ($quantity > $sku->stock) {
            $fail("La cantidad disponible que puedes llevar de este producto es de: $sku->stock  unidade(s)");
        }
    }
}
