<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountCodeRequest;
use App\Http\Resources\ProductResource;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Rules\ValidateProductRule;
use App\Services\DiscountCodeService;
use App\Services\OrderService;
use App\Services\StockService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CheckoutController extends Controller
{
	public function checkout(Request $request)
	{
		$productsId = session('productsId');
		$quantities = session('quantities');

		if (!$productsId || !$quantities) {
			return to_route('home');
		}

		$products = Product::whereIn('id', $productsId)->with('stock')->get();

		$productsPricesQuantity = OrderService::priceQuantity($products, $quantities);

		$productInStock = OrderService::productInStock($productsPricesQuantity);

		$discountCode = session('discountCode');

		$discountCodeValidated = DiscountCodeService::IsAvailable($discountCode);

		$charges = OrderService::calculateTotalPrice($productInStock, $discountCodeValidated);


		$dicountCodes = DiscountCode::whereDate('start_date', '<=', now())
			->whereDate('end_date', '>=', now())
			->where('active', 1)->inRandomOrder()->limit(5)->get();

		return Inertia::render('Checkout/Checkout', [
			'products' => ProductResource::collection($productsPricesQuantity),
			'charges' => $charges,
			'dicountCodes' => $dicountCodes,
		]);
	}
	public function product(Request $request)
	{
		$request->validate([
			'quantity' => 'required|numeric|min:1',
			'product_id' => ['required', 'exists:products,id', new ValidateProductRule]
		]);

		session([
			'productsId' => [$request->product_id],
			'quantities' => [$request->product_id => $request->quantity],
		]);

		return to_route('checkout');
	}

	public function shopping_cart(Request $request)
	{
		$products = auth()->user()->shopping_cart->load('specifications', 'stock');

		$quantities = $products->pluck('pivot.quantity', 'id')->toArray();

		$products = OrderService::priceQuantity($products, $quantities);

		$productInStock = OrderService::productInStock($products);

		session([
			'productsId' => $productInStock->pluck('id')->toArray(),
			'quantities' => $productInStock->pluck('quantity_selected', 'id')->toArray(),
		]);

		return to_route('checkout');
	}

	public function discount(DiscountCodeRequest $request)
	{
		session(['discountCode' => $request->discountCode]);
		return to_route('checkout');
	}
	public function discountDelete()
	{
		session()->forget(['discountCode']);
		return to_route('checkout');
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
			'code' => OrderService::generate_code(auth()->user()->id),
			'quantity' => $charges['quantity'],
			'shipping' => $charges['shipping'],
			'tax_amount' => $charges['tax_amount'],
			'tax_percent' => $charges['tax_percent'],
			'sub_total' => $charges['sub_total'],
			'total' => $charges['total'],
			'user_id' => auth()->user()->id,
			'user_json' => $request->only('name', 'address', 'phone', 'email', 'city'),
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

		return Redirect::to(route('order', $order->code))->with('success', 'orden creada con exito');
	}
}
