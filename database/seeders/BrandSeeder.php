<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Brand;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::truncate();
        $products = collect(Storage::json(env('DB_FAKE_PRODUCTS')));
        $brands = $products->pluck('brand')->unique()->map(function ($item) {
            $slug = Str::slug($item);
            return [
                'name' => $item,
                'slug' => $slug,
                'img' => "/img/brands/$slug.png",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();
        Brand::insert($brands);
    }
}
