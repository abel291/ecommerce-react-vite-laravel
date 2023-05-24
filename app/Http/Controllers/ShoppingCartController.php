<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingCartStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Rules\ShoppingCartStoreRule;
use App\Rules\ValidateProductRule;
use App\Services\OrderService;
use App\Services\ShoppingCartService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ShoppingCartController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$products = $this->getProducts();

		$quantities = $products->pluck('pivot.quantity', 'id')->toArray();

		$products = OrderService::priceQuantity($products, $quantities);

		$products = $products->map(function ($item) {
			$item->in_stock = $item->stock->remaining >= $item->quantity_selected;
			return $item;
		});

		$productInStock = OrderService::productInStock($products);

		$charges = OrderService::calculateTotalPrice($productInStock);

		return Inertia::render('ShoppingCart/ShoppingCart', [
			'products' => ProductResource::collection($products),
			'charges' => $charges,
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
	public function store(Request $request)
	{

		$request->validate([
			'quantity' => 'required|numeric|min:1',
			'product_id' => ['required', 'exists:products,id', new ValidateProductRule, new ShoppingCartStoreRule],
		]);

		$product = Product::find($request->product_id);

		ShoppingCartService::addProduct(auth()->user(), $product, $request->quantity);

		return to_route('shopping-cart.index')->with('success', "Agregaste a tu carrito <b>$product->name</b> ");
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
		auth()->user()->shopping_cart()->detach($id);
		return to_route('shopping-cart.index')->with('success', '¡Listo! Eliminaste el producto.');
	}

	public function getProducts()
	{
		return auth()->user()->shopping_cart->load('stock', 'specifications')->sortByDesc('pivot.id')->values();
	}
}
