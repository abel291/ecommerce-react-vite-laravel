<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\CartEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutProductRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use Faker;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {

        $products = CartService::session(CartEnum::CHECKOUT->value);

        $discountCode = session()->get('discountCode');

        $total = OrderService::calculateTotal($products, $discountCode);

        $discount_codes = DiscountCode::whereDate('valid_from', '<=', now())
            ->whereDate('valid_to', '>=', now())
            ->where('active', 1)->inRandomOrder()->limit(5)->get();

        $faker = Faker\Factory::create();
        $note = $faker->paragraph(2);

        return Inertia::render('Checkout/Checkout', [
            'products' => CartResource::collection($products),
            'total' => $total,
            'dicountCodes' => $discount_codes,
            'note' => $note,
            //'clientSecret' => auth()->user()->createSetupIntent()->client_secret
        ]);
    }

    public function addSingleProduct(CheckoutProductRequest $request)
    {
        $product = Product::select('id', 'name', 'price', 'img', 'price_offer', 'slug', 'max_quantity')->with('stock')->find($request->product_id);

        CartService::add(CartEnum::CHECKOUT->value, $product, $request->quantity, $request['attributes']);

        return to_route('checkout');
    }

    public function addShoppingCart()
    {
        $products = CartService::session(CartEnum::SHOPPING_CART->value);

        session([CartEnum::CHECKOUT->value => $products]);

        return to_route('checkout');
    }
}
