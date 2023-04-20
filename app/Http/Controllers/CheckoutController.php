<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
	public function checkout(Request $request)
	{
		$product = Product::where('id', $request->product_id)->where('stock', '>=', $request->quantity)->first();
		$amount = 0;

		$product->total_price_quantity = $product->price * $request->quantity;
		$product->quantity = $request->quantity;

		$charges = OrderService::calculate_total_price($product->total_price_quantity);

		return response()->json([
			'products' => [$product],
			'charges' => $charges,
		]);
	}

	public function shopping_cart_checkout(Request $request)
	{
		$products = auth()->user()->shopping_cart->load('specifications');

		foreach ($products as $product) {
			$product->total_price_quantity = $product->pivot->total_price_quantity;
			$product->quantity = $product->pivot->quantity;
		}

		$amount = $products->sum('total_price_quantity');
		$charges = OrderService::calculate_total_price($amount);

		return response()->json([
			'products' => $products,
			'charges' => $charges,
		]);
	}
}
