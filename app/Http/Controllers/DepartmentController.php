<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function department($department)
    {

        $department = Department::active()->where('slug', $department)->firstOrFail();

        // $offers_product = $department->products()->card()->activeInStock()
        //     ->inOffer()->limit(15)->get();

        $offers_product = Product::where('department_id', $department->id)->card()->inStock()->inOffer()->limit(15)->get();

        $best_sellers_product = Product::where('department_id', $department->id)->card()->inStock()->inOffer()->limit(10)->get();



        $categories = Category::active()
            ->withWhereHas('products', function ($query) use ($department) {
                $query->card()->inStock()->where('department_id', $department->id)->limit(10);
            })->get();


        // $brands = Brand::select('name', 'slug', 'img')->active()
        //     ->withCount(['products' => function ($query) use ($department) {
        //         $query->whereRelation('department', 'id', $department->id);
        //     }])
        //     ->whereHas('products.department', function ($query) use ($department) {
        //         $query->where('id', $department->id);
        //     })
        //     ->orderBy('products_count', 'desc')
        //     ->inRandomOrder()->limit(20)
        //     ->get();

        return Inertia::render('Department/Department', [
            'department' => $department,
            'offertProduct' => ProductResource::collection($offers_product),
            'bestSellersProduct' => $best_sellers_product,
            'categories' => $categories,

        ]);
    }
}
