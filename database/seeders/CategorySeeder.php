<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Department;
use App\Models\MetaTag;
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

        Category::factory()->count(5)->create([
            'type' => 'blog',
            'in_home' => false,
        ]);

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));

        $departments = $products->pluck('department')->unique();
        foreach ($departments as $value) {
            # code...

            $slug = Str::slug($value);
            Department::factory()
                ->has(MetaTag::factory()->state([
                    'meta_title' => $value
                ]))
                ->create([
                    'name' => $value,
                    'slug' => $slug,
                    'img' => "/img/departments/$slug.png",
                ]);
        }



        //////////////////////////////////

        $categories = $products->pluck('category')->unique();
        foreach ($categories as $value) {
            $slug = Str::slug($value);

            Category::factory()
                // ->has(MetaTag::factory())
                ->create([
                    'name' => ucfirst($value),
                    'slug' => $slug,
                    'entry' => fake()->text(250),
                    'type' => 'product',
                    'img' => "/img/categories/$slug.png",
                ]);
        }



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
    }
}
