<?php

namespace App\Http\Controllers;

use App\Enums\CartEnum;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Rules\ShoppingCartStoreRule;
use App\Rules\ValidateProductRule;
use App\Services\CartService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * LaravelShoppingcart https://github.com/hardevine/LaravelShoppingcart#usage
 */
class ShoppingCartController extends Controller
{

	public function index()
	{
		$cart = Cart::instance(CartEnum::SHOPPING_CART->value);

		$total = OrderService::calculateTotal($cart->subtotal());

		return Inertia::render('ShoppingCart/ShoppingCart', [
			'cardProducts' => CartResource::collection($cart->content()->values()),
			'total' => $total,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Inertia\Response
	 */
	// public function create()
	// {
	// 	//
	// }

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'quantity' => ['required', 'numeric', 'min:1', new ValidateProductRule, new ShoppingCartStoreRule],
			'product_id' => ['required', 'exists:products,id'],
		]);

		$product = Product::query()->select('id', 'name', 'price', 'img', 'price_offer', 'slug')->findOrFail($request->product_id);

		$options['attributes'] = CartService::formatAttributes($request['attributes']);

		CartService::add(CartEnum::SHOPPING_CART->value, $product, $request->quantity, $options);

		return to_route('shopping-cart.index')->with('success', "Agregaste a tu carrito $product->name");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Inertia\Response
	 */
	// public function show($id)
	// {
	// }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Inertia\Response
	 */
	// public function edit($id)
	// {
	// 	//
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Inertia\Response
	 */
	public function update(Request $request, $id): RedirectResponse
	{
		$cart = Cart::instance(CartEnum::SHOPPING_CART->value);
		$cardProduct = $cart->content()->firstWhere('id', $id);
		$cart->update($cardProduct->rowId, $request->quantity);
		return to_route('shopping-cart.index')->with('success', "Carrito de compra actualizado");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id): RedirectResponse
	{
		$cart = Cart::instance(CartEnum::SHOPPING_CART->value);
		$cardProduct = $cart->content()->firstWhere('id', $id);
		$cart->remove($cardProduct->rowId);
		return to_route('shopping-cart.index')->with('success', '¡Listo! Eliminaste el producto.');
	}
}
