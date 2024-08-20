<?php

namespace App\Rules;

use App\Models\Presentation;
use App\Models\Product;
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
        $codePresentation = $this->data['codePresentation'];
        $product_id = $this->data['product_id'];

        $presentation = Presentation::where('code', $codePresentation)
            // ->where('quantity', '>=', $quantity)
            ->whereHas('product', function ($query) {
                $query->active();
            })->first();

        if (!$presentation) {
            $fail('Este producto no esta disponible');
        }

        if ($quantity > $presentation->stock) {
            $fail('No hay stock suficiente para este producto');
        }
    }
}
