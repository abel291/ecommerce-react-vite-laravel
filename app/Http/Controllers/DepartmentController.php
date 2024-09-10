<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCardResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VariantProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Models\Variant;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function department($department)
    {

        $department = Department::active()->where('slug', $department)->firstOrFail();

        // $offers_product = $department->products()->card()->activeInStock()
        //     ->inOffer()->limit(15)->get();

        $offers_product = Product::variant()
            ->where('department_id', $department->id)
            ->card()
            ->activeInStock()
            ->inOffer()
            ->limit(15)
            ->inRandomOrder()
            ->get();

        $best_sellers_product = Product::variant()
            ->where('department_id', $department->id)
            ->card()
            ->activeInStock()
            ->inOffer()
            ->limit(10)
            ->inRandomOrder()
            ->get();

        $categories = Category::active()
            ->withWhereHas('products', function ($query) use ($department) {
                $query->variant()->card()->activeInStock()->inRandomOrder()->where('department_id', $department->id)->limit(10);
            })->get();

        return Inertia::render('Department/Department', [
            'department' => $department,
            'offertProducts' => ProductCardResource::collection($offers_product),
            'bestSellersProducts' => ProductCardResource::collection($best_sellers_product),
            'categories' => CategoryResource::collection($categories),

        ]);
    }
}
