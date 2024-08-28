<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Department;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('category_department')->truncate();

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

        $categories = $products->pluck('category')->unique()->map(function ($category_name) {

            $slug = Str::slug($category_name);

            return [
                'name' => ucfirst($category_name),
                'slug' => Str::slug($category_name),
                'entry' => fake()->text(250),
                'type' => 'product',
                'img' => "/img/categories/$slug.png",
            ];
        });

        Category::insert($categories->toArray());


        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');
        $categories = Category::select('id', 'name')->get()->pluck('id', 'name');

        $category_department = [];
        foreach ($products as $product) {
            $category_department[] = [
                'category_id' => $categories[$product['category']],
                'department_id' => $departments[$product['department']],
            ];
        }

        $category_department = collect($category_department)->unique();

        DB::table('category_department')->insert($category_department->toArray());

        Category::factory()->count(5)->create([
            'type' => 'blog'
        ]);
    }
}
