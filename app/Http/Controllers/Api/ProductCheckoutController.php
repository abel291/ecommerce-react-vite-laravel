<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCheckoutController extends Controller
{
    public function product_checkout(Request $request)
    {
        $product = Product::where('id', $request->product_id)->where('availables', '>=', $request->quantity)->first();
        $amount = 0;

        $product->total_price_quantity = $product->price * $request->quantity;
        $product->quantity = $request->quantity;

        $charges = Helpers::get_charges_products($product->total_price_quantity);

        return response()->json([
            'products' => [$product],
            'charges' => $charges
        ]);
    }

    public function product_checkout_cart(Request $request)
    {
        $products = auth()->user()->card_products->load('specifications');
        
        foreach ($products as $key => $product) {
            $product->total_price_quantity = $product->pivot->total_price_quantity;
            $product->quantity = $product->pivot->quantity;
        }
        // DB::table('base_lines')
        // ->join('utility_rates_base_lines', 'base_lines.id', '=', 'utility_rates_base_lines.base_line_id')
        // ->join('utility_rates', 'utility_rates.id', '=', 'utility_rates_base_lines.utility_rate_id')
        // ->where('base_lines.electricity_code_id', '=', $electricityCodeId)
        // ->where('base_lines.territory_code_id', '=', $territoryCodeId)
        // ->where('utility_rates.rate_schedule_id', '=', $rateScheduleId)
        // ->select('base_lines.*')->get();

        $amount = $products->sum('total_price_quantity');
        $charges = Helpers::get_charges_products($amount);

        return response()->json([
            'products' => $products,
            'charges' => $charges
        ]);
    }
}
