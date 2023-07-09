<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUserRequest extends FormRequest
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
			'name' => 'required|max:255',
			'address' => 'required|max:255',
			'phone' => 'required|max:255',
			'email' => 'required|max:255|email',
			'city' => 'required|max:255',
			'postalCode' => 'nullable|max:255',
			'note' => 'nullable|max:255',
		];
	}
}
