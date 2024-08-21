<?php

namespace App\Http\Requests;

use App\Rules\ValidateProductRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutProductRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
            'product_id' => ['required', 'exists:products,id', new ValidateProductRule],
            'codePresentation' => ['required', 'exists:presentations,code', new ValidateProductRule],
        ];
    }
}
