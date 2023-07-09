<?php

namespace App\Rules;

use App\Models\Product;
use App\Services\CartService;
use Closure;
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
		$product_id = $this->data['product_id'];

		$product = Product::with('stock')->findOrFail($product_id);

		$max_items = config('cart.shopping-cart.max-quantity');

		$shopping_cart = auth()->user()->shoppingCart()->get();

		$shoppinCartProductsInSTock = CartService::filterProductsInStock($shopping_cart);

		$shoppinCartProductsInSTock->transform(function ($item) use ($product_id, $quantity) {

			if ($item->product_id == $product_id) {
				$item->quantity_selected = $quantity;
			}

			return $item;
		});
		//dd($shoppinCartProductsInSTock->sum('quantity_selected'));

		if ($shoppinCartProductsInSTock->sum('quantity_selected') >= $max_items) {
			$fail("Carrito lleno! ,no puedes tener mas de $max_items productos en el carritos");
		}

		if ($quantity > $product->max_quantity) {
			$fail("La cantidad maxima que puedes llevar de este producto es de: $product->max_quantity unidade(s)");
		}
	}
}
