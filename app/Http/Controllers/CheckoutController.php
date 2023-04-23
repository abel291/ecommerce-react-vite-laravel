<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
	public function checkout(Request $request)
	{
		$product = Product::where('stock', '>=', $request->quantity)->find($request->product_id);

		$product->total_price_quantity = $product->price_offer * $request->quantity;
		$product->quantity = $request->quantity;

		$charges = OrderService::calculate_total_price($product->total_price_quantity);

		$this->set_session_data(collect([$product]), $charges);

		return Inertia::render('Checkout/Checkout', [
			'products' => ProductResource::collection(collect([$product])),
			'charges' => $charges,
		]);
	}

	public function shopping_cart_checkout(Request $request)
	{
		$products = auth()->user()->shopping_cart->load('specifications');

		$products->transform(function ($item) {
			$item->total_price_quantity = $item->pivot->total_price_quantity;
			$item->quantity = $item->pivot->quantity;
			return $item;
		});

		$amount = $products->sum('total_price_quantity');
		$charges = OrderService::calculate_total_price($amount);

		$this->set_session_data($products, $charges);

		return Inertia::render('Checkout/Checkout', [
			'products' => ProductResource::collection($products),
			'charges' => $charges,
		]);
	}

	public function set_session_data($products, $charges)
	{
		$charges['quantity'] = $products->sum('quantity');

		$array_produsts = $products->map(function ($item, $key) {
			return $item->only(['id', 'name', 'price', 'price_offer', 'quantity', 'total_price_quantity']);
		})->toArray();

		session([
			'products' => $array_produsts,
			'charges' => $charges,
		]);
	}


	public function pay(Request $request)
	{

		$request->validate([
			'name' => 'required|max:255',
			'address' => 'required|max:255',
			'phone' => 'required|max:255',
			'email' => 'required|max:255|email',
			'city' => 'required|max:255',
			'postalCode' => 'nullable|max:255',
			'note' => 'nullable|max:255',
		]);

		$charges = session('charges');
		$products = session('products');


		DB::beginTransaction();
		$order = Order::create([
			'code' => OrderService::generate_code(),
			'quantity' => $charges['quantity'],
			'shipping' => $charges['shipping'],
			'tax_amount' => $charges['tax_amount'],
			'tax_percent' => $charges['tax_percent'],
			'sub_total' => $charges['sub_total'],
			'total' => $charges['total'],
			'user_id' => auth()->user()->id,
			'user_json' => $request->only('name', 'address', 'phone', 'email', 'city', 'postalCode', 'note'),
			'status' => 'success',
		]);

		$order_products = [];
		foreach ($products as $item) {
			array_push($order_products, [
				'name' => $item['name'],
				'price' => $item['price_offer'],
				'quantity' => $item['quantity'],
				'price_quantity' => $item['total_price_quantity'],
				'product_id' => $item['id'],
			]);
		}

		$order->products()->createMany($order_products);
		DB::commit();

		session()->forget(['charges', 'products']);

		return Redirect::to(route('order', $order->code));
	}
}
