<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helpers
{
    public $categoryJson;



    public static function getAllProducts()
    {
        return self::joinJson();
    }

    public static function getAllCategories()
    {
        $category_json = env('TYPE_ECOMMERCE') . "/department_categories.json";

        if (Storage::fileExists($category_json)) {
            return Storage::json($category_json);
        }

        $products = self::getAllProducts();

        $data['departments'] = $products->groupBy('department')->map(function ($item, $departments_name) {

            return Department::factory()->make([
                'name' => ucfirst($departments_name),
                'slug' => Str::slug($departments_name),
                //'entry' => $departments_name,
                'meta_title' => $departments_name,
                'img' =>  "/storage/img/departments/" . Str::slug($departments_name) . '.png',
                'categories' => $item->unique('category')->pluck('category')->map(function ($category) {
                    return Str::slug($category);
                })
            ])->toArray();
        });

        $data['categories'] = $products->unique('category')->pluck('category')->map(function ($category) {
            //$category_name = ucfirst(Str::slug($category, ' '));
            return Category::factory()->make([
                'name' => $category,
                'slug' => Str::slug($category),
                //'entry' => $departments_name,
                'img' =>  "/storage/img/categories/" . Str::slug($category) . '.png',
            ])->toArray();
        })->toArray();

        Storage::put($category_json, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return $data;
    }

    public static function getAllBrands()
    {
        return self::joinJson()->unique('brand')->pluck('brand');
    }

    public static function joinJson()
    {

        $directory_json = env('TYPE_ECOMMERCE') . "/products_with_images.json";
        $products = collect(Storage::json($directory_json));
        return collect($products)->shuffle();
    }
}
