<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\CartEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUserRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class PaymentCheckoutController extends Controller
{
	public function purchase(OrderUserRequest $request)
	{

		$checkoutProducts = Cart::instance(CartEnum::CHECKOUT->value);
		$products = $checkoutProducts->content()->values();

		$user = auth()->user();

		$discountCode = session()->get('discountCode');
		$total = OrderService::calculateTotal($checkoutProducts->subtotal(), $discountCode);

		try {
			DB::beginTransaction();

			$order = OrderService::createOrderWithTotalCalculation($total);
			$order->quantity = $checkoutProducts->count();
			$order->code = OrderService::generateCode($user->id);
			$order->data = [
				'user' => $request->only('name', 'address', 'phone', 'email', 'city', 'note'),
			];
			$order->user_id = $user->id;
			$order->save();

			$order_products = $products->values()->map(function ($product) use ($user) {
				return [
					'price' => $product->price,
					'quantity' => $product->qty,
					'total' => $product->total(),
					'data' => $product->model->only('name', 'slug', 'img'),
					'attributes' => $product->options->attributes,
					'user_id' => $user->id,
					'product_id' => $product->model->id,
				];
			});
			$order->order_products()->createMany($order_products);

			// $paymentCharge = PaymentService::charger($user, $order, $request->paymentMethodId);

			$payment = new Payment([
				'status' => PaymentStatus::SUCCESSFUL,
				'method' => PaymentMethodEnum::CARD,
				// 'reference' => $paymentCharge->id,
				'reference' => 'payment',
			]);

			$order->payment()->save($payment);

			//checkout clean
			Cart::instance(CartEnum::CHECKOUT->value)->destroy();

			DB::commit();
		} catch (\Stripe\Exception\CardException $e) {

			DB::rollback();

			return back()->withErrors(['card' => $e->getMessage()]);
		} catch (Exception $e) {

			DB::rollback();

			return back()->withErrors(['card' => $e->getMessage()]);
		}

		session()->forget(['cart_products', 'discount_code', 'order']);

		$message = 'Tu pedido llega entre ' . now()->addDays(2)->isoFormat('DD') . ' y el ' . now()->addDays(7)->isoFormat('DD \d\e MMMM');

		return to_route('profile.order', $order->code)->with(['success' => $message]);
	}
}
