<?php

namespace App\Rules;

use App\Models\Product;
use App\Services\OrderService;
use App\Services\ShoppingCartService;
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

		$product = Product::with('stock')->find($product_id);

		$shopping_cart_max_items = config('shoppingcart.max_quantity');

		$shopping_cart = auth()->user()->shopping_cart()->get();

		$shopping_cart_product_in_stock = OrderService::productInStock($shopping_cart);

		$product_selected_shopping_cart = $shopping_cart_product_in_stock->firstWhere('id', $product->id);

		if ($product_selected_shopping_cart) {

			$shopping_cart_products_count = ($shopping_cart_product_in_stock->sum('pivot.quantity') - $product_selected_shopping_cart->pivot->quantity) + $quantity;
		} else {

			$shopping_cart_products_count = $shopping_cart_product_in_stock->sum('pivot.quantity')  + $quantity;
		}

		if ($quantity > $product->max_quantity) {
			$fail("La cantidad maxima que puedes llevar de este producto es de: $product->max_quantity unidade(s)");
		}

		if ($shopping_cart_products_count > $shopping_cart_max_items) {
			$fail("Carrito lleno! ,no puedes tener mas de $shopping_cart_max_items productos en el carritos");
		}
	}
}
