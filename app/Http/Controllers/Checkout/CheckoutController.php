<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutProductRequest;
use App\Http\Resources\OrderResource;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CheckoutService;
use Faker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $order_products = session('cart_products');
        $order = session('order');

        //var temp
        $discount_codes = DiscountCode::whereDate('valid_from', '<=', now())
            ->whereDate('valid_to', '>=', now())
            ->where('active', 1)->inRandomOrder()->limit(5)->get();
        $faker = Faker\Factory::create();
        $note = $faker->paragraph(2);

        return Inertia::render('Checkout/Checkout', [
            'orderProducts' => $order_products,
            'order' => new OrderResource($order),
            'dicountCodes' => $discount_codes,
            'note' => $note,
            //'clientSecret' => auth()->user()->createSetupIntent()->client_secret
        ]);
    }

    public function addSingleProduct(CheckoutProductRequest $request)
    {

        $product = Product::with('stock')->find($request->product_id);

        $cart_product = CartService::generateCartProduct($product, $request->quantity);

        $cart_products = collect([$cart_product]);

        CheckoutService::addProducts($cart_products);

        return to_route('checkout');
    }

    public function addShoppingCart()
    {
        $card_product = auth()->user()->shoppingCart->load('product.stock');

        $cart_product_in_stock = CartService::filterProductsInStock($card_product);

        CheckoutService::addProducts($cart_product_in_stock);

        return to_route('checkout');
    }
}
