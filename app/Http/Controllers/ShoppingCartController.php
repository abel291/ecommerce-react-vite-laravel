<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\OrderService;
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
	public function index(Request $request)
	{
		$products = $this->get_products();
		$amount = $products->sum('pivot.total_price_quantity');
		$charges = OrderService::calculate_total_price($amount);

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

		$validated = $request->validate([
			'quantity' => 'required|numeric|min:1',
			'product_id' => 'required',
		]);
		//$user=auth()->user();
		$user = auth()->user();
		$products = $this->get_products();
		$product = $products->firstWhere('id', $request->product_id);

		//si el productos ya esta en el carritos no se agrega otro, solo se le cambia la cantidad a este
		if ($product && $product->stock >= $request->quantity) {
			$product->pivot->quantity = $request->quantity;
			$product->pivot->total_price_quantity = $product->price_offer * $request->quantity;
			$product->pivot->save();
		}

		//agregar nuevo producto al carrito
		if (!$product && $request->purchase == false) {

			//limite de productos para el carrito
			$max_products = 5;
			if ($products->count() >= $max_products) {
				Redirect::back()->with('error', 'Carrito lleno! ,no puedes tener mas de ' . $max_products . ' productos en el carritos');
			}

			$product = Product::where('id', $request->product_id)->where('stock', '>=', $request->quantity)->first();
			//dd($product);
			if ($product) {
				$user->shopping_cart()->attach($product->id, [
					'quantity' => $request->quantity,
					'total_price_quantity' => $product->price_offer * $request->quantity,
				]);
				return to_route('shopping-cart.index')->with('success', 'Agregaste a tu carrito "' . $product->name . ' " ');
				// $products = $user->shopping_cart()->with('specifications')->get();
			}
		}
		return to_route('shopping-cart.index');


		// $amount = $products->sum('pivot.total_price_quantity');
		// $charges = OrderService::calculate_total_price($amount);

		// return response()->json([
		// 	'products' => $products,
		// 	'charges' => $charges,
		// ]);
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

	public function get_products()
	{
		return auth()->user()->shopping_cart->load('specifications')->sortByDesc('pivot.id')->values();
	}
}
