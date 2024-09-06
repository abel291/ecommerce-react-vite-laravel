<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\CartEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderUserRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Sku;
use App\Services\CartService;
use App\Services\OrderService;

use Illuminate\Support\Facades\DB;

class PaymentCheckoutController extends Controller
{
    public function purchase(OrderUserRequest $request)
    {

        $user = auth()->user();
        $discountCode = session()->get('discountCode');

        $products = CartService::session(CartEnum::CHECKOUT);
        $orderProducts = OrderService::generateOrderProductsCheckout($products);

        $order = OrderService::generateOrder($orderProducts, $discountCode, $user);

        DB::transaction(function () use ($order, $orderProducts, $request) {

            $order->status = OrderStatusEnum::SUCCESSFUL;
            $order->data = [
                'user' => $request->all()
            ];
            $order->save();

            $order->orderProducts()->createMany($orderProducts);

            Payment::create([
                'method' => PaymentMethodEnum::CARD,
                // 'reference' => $paymentCharge->id,
                'reference' => 'payment',
                'order_id' => $order->id
            ]);

            //checkout clean
            session()->forget(CartEnum::CHECKOUT->value);
            session()->forget(CartEnum::SHOPPING_CART->value);
            session()->forget('discountCode');
        });

        $message = 'Tu pedido llega entre ' . now()->addDays(2)->isoFormat('DD') . ' y el ' . now()->addDays(7)->isoFormat('DD \d\e MMMM');

        return to_route('profile.order', $order->code)->with(['success' => $message]);
    }
}
