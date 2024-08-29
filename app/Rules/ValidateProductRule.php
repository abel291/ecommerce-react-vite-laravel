<?php

namespace App\Rules;

use App\Models\Presentation;
use App\Models\Product;
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
        $variandRef = $this->data['variandRef'];
        $variantSizeId = $this->data['variantSizeId'];

        $variant = Variant::active()->where('ref', $variandRef)
            ->withWhereHas('sizes', function ($query) use ($variantSizeId) {
                $query->find($variantSizeId);
            })
            ->first();

        if (!$variant) {
            $fail('Este producto no esta disponible');
        }

        if ($quantity > $variant->sizes->first()->stock) {
            $fail('No hay stock suficiente para este producto');
        }
    }
}
