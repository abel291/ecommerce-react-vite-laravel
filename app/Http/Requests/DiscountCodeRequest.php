<?php

namespace App\Http\Requests;

use App\Services\DiscountCodeService;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class DiscountCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'discountCode' => [
                'required', 'exists:discount_codes,code',
                function (string $attribute, mixed $value, Closure $fail) {
                    $discount = DiscountCodeService::IsAvailable($value);
                    if (! $discount) {
                        $fail("El codigo de descuento $value no esta disponible");
                    }
                },
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'discountCode.exists' => 'El codigo de descuento seleccionado no es válido.',
        ];
    }
}
