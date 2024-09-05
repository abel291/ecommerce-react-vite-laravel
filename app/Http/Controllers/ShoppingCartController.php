<?php

namespace App\Http\Controllers;

use App\Enums\CartEnum;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Rules\ShoppingCartStoreRule;
use App\Rules\ValidateProductRule;
use App\Services\CartService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * LaravelShoppingcart https://github.com/hardevine/LaravelShoppingcart#usage
 */
class ShoppingCartController extends Controller
{

    public function index()
    {
        // sleep(3000);
        //session()->forget(CartEnum::SHOPPING_CART->value);

        $products = CartService::products();
        // dd($products);
        $total = OrderService::calculateTotal($products);
        // dd($products);
        return Inertia::render('ShoppingCart/ShoppingCart', [
            'products' => $products,
            'total' => $total,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    // public function create()
    // {
    // 	//
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'skuId' => ['required', 'exists:skus,id', new ValidateProductRule, new ShoppingCartStoreRule],
            'quantity' => ['required', 'numeric', 'min:1'],
        ]);

        CartService::add(CartEnum::SHOPPING_CART, $request->skuId, $request->quantity);

        $product = Product::select('id', 'name')
            ->whereRelation('sku', 'id', $request->skuId)
            ->first();

        // return redirect()->back()->with('success', "Agregaste a tu carrito $product->name");
        return to_route('shopping-cart.index')->with('success', "Agregaste a tu carrito $product->name");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    // public function show($id)
    // {
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    // public function edit($id)
    // {
    // 	//
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function update(Request $request, $rowId): RedirectResponse
    {
        // $request->validate([
        //     'quantity' => ['required', 'numeric', 'min:1', new ValidateProductRule, new ShoppingCartStoreRule],
        //     'product_id' => ['required', 'exists:products,id'],
        // ]);

        // $product = Product::select('id', 'name', 'price', 'img', 'price_offer', 'slug', 'max_quantity')->with('stock')->findOrFail($request->product_id);

        // CartService::update(CartEnum::SHOPPING_CART->value, $rowId, $request->quantity);

        // return to_route('shopping-cart.index')->with('success', "Carrito de compra actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $rowId
     */
    public function destroy($skuId): RedirectResponse
    {

        CartService::remove(CartEnum::SHOPPING_CART, $skuId);

        return to_route('shopping-cart.index')->with('success', '¡Listo! Eliminaste el producto.');
    }
}
