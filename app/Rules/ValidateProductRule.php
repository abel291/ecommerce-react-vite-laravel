<?php

namespace App\Rules;

use App\Models\Presentation;
use App\Models\Product;
use App\Models\Sku;
use App\Models\Variant;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateProductRule implements DataAwareRule, ValidationRule
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

        $sku = Sku::where('stock', '>', 0)
            ->whereRelation('variant', 'active', 1)
            ->find($skuId);

        if (!$sku) {
            $fail('Este producto no esta disponible');
        }

        // if ($quantity > $sku->stock) {
        //     $fail('No hay stock suficiente para este producto');
        // }
    }
}
