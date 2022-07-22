<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $products = [];
        $categories = [];
        $brands = [];
        $prices = [];
        $specifications = [];

        $products = Product::with('category', 'brand')->where(function ($query) use ($request) {
            $query->orWhere('name', 'like', "%$request->q%");
            $query->orWhere('description_max', 'like', "%$request->q%");
            $query->orWhere('description_max', 'like', "%$request->q%");
        });

        if ($request->sortBy) {
            $sorBy = $request->sortBy == 'price_desc' ? 'desc' : 'asc';
            $products->orderBy('price', $sorBy);
        } else {
            $products->orderBy('id', 'desc');
        }

        if ($request->categories) {
            //$categories = explode(',', $request->categories);
            $products->whereHas('category', function (Builder $query) use ($request) {
                $query->whereIn('slug', $request->categories);
            });
        }
        if ($request->brands) {
            //$brands = explode(',', $request->brands);
            $products->whereHas('brand', function (Builder $query) use ($request) {
                $query->whereIn('slug', $request->brands);
            });
        }
        if ($request->price_min) {
            $products->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $products->where('price', '<=', $request->price_max);
        }
        if ($request->offers) {
            $products->where('offer', '>=', $request->offers);
        }
        $products = $products->paginate(15);

        return  compact('products');
    }
}
