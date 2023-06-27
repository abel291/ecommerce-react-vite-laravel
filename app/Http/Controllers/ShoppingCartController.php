<?php

namespace App\Http\Controllers;


use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Rules\ShoppingCartStoreRule;
use App\Rules\ValidateProductRule;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

use Inertia\Inertia;

class ShoppingCartController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CartService $cart_service)
	{
		$cart_products = auth()->user()->shoppingCart->load('product.stock', 'product.specifications')->sortByDesc('id');

		$cart_products = $cart_service->refreshPrice($cart_products);

		$cart_products_in_sctock = $cart_service->filterProductsInStock($cart_products);

		$order = OrderService::calculateTotals($cart_products_in_sctock);

		return Inertia::render('ShoppingCart/ShoppingCart', [
			'shoppingCart' => CartResource::collection($cart_products),
			'order' => new  OrderResource($order),
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, CartService $cart_service)
	{
		$request->validate([
			'quantity' => 'required|numeric|min:1',
			'product_id' => ['required', 'exists:products,id', new ValidateProductRule, new ShoppingCartStoreRule],
		]);

		$product = Product::find($request->product_id);

		$cart_service->addProduct(auth()->user(), $product, $request->quantity);

		return to_route('shopping-cart.index')->with('success', "Agregaste a tu carrito $product->name ");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		auth()->user()->shoppingCart()->find($id)->delete();
		return to_route('shopping-cart.index')->with('success', '¡Listo! Eliminaste el producto.');
	}
}
