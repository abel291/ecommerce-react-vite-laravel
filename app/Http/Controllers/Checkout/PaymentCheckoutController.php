<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\CartEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUserRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentCheckoutController extends Controller
{

	public function purchase(OrderUserRequest $request)
	{
		$cart_products = session('cart_products');
		$order = session('order');
		$user = auth()->user();

		try {
			DB::beginTransaction();

			$order->user_id = $user->id;
			$order->code = OrderService::generateCode($user->id);
			$order->user_data = $request->only('name', 'address', 'phone', 'email', 'city', 'note');
			$order->save();

			$order_products = $cart_products->map(function ($item) {
				$item->type = CartEnum::ORDER;
				return  $item;
			});

			$order->order_products()->saveMany($order_products);

			// $paymentCharge = $user->charge($order['total'] * 100, $request->paymentMethodId, [
			// 	'metadata' => [
			// 		'order_code' => $order->code,
			// 		'quantity_products' => $order->quantity
			// 	],
			// 	'description' => "Compra Por internet $order->code - $user->email"
			// ]);

			$payment = new Payment([
				'status' => PaymentStatus::SUCCESSFUL,
				'method' => PaymentMethodEnum::CARD,
				//'reference' => $paymentCharge->id,
			]);

			$order->payment()->save($payment);

			DB::commit();
		} catch (\Stripe\Exception\CardException $e) {

			DB::rollback();
			return back()->withErrors(['card' => $e->getMessage()]);
		} catch (Exception $e) {

			DB::rollback();
			return back()->withErrors(['card' => $e->getMessage()]);
		}

		session()->forget(['cart_products', 'discount_code', 'order']);

		$message = "Tu pedido llega entre " . now()->addDays(2)->isoFormat('DD') . " y el " . now()->addDays(7)->isoFormat('DD \d\e MMMM');

		return to_route('order', $order->code)->with(['success' => $message]);
	}
}
