<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Department;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        Department::truncate();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));

        $departments = $products->pluck('department')->unique()->map(function ($item) {

            $slug = Str::slug($item);
            return Department::factory()->make([
                'name' => $item,
                'slug' => $slug,
                'icon' => "/img/" . env('ECOMMERCE_TYPE') . "/departments/icon-$slug.png",
                'img' => "/img/" . env('ECOMMERCE_TYPE') . "/departments/$slug.png",
            ]);
        });

        Department::insert($departments->toArray());

        //////////////////////////////////

        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');

        $categories = $products->unique('category')->map(function ($item) use ($departments) {

            $slug = Str::slug($item['category']);
            return Category::factory()->make([
                'name' => $item['category'],
                'slug' => $slug,
                'img' => "/img/" . env('ECOMMERCE_TYPE') . "/categories/$slug.png",
                'department_id' => $departments[$item['department']]
            ]);
        });

        Category::insert($categories->toArray());

        Category::factory()->count(5)->create([
            'type' => 'blog'
        ]);
    }
}
