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
        $data = Storage::json("clothes/department_categories.json");

        foreach ($data['categories'] as $key => $category) {
            Category::create($category);
        }

        $categories = Category::select('id', 'slug')->get();

        foreach ($data['departments'] as $department) {

            $department_model = Department::factory()->create([
                'name' => $department['name'],
                'slug' => $department['slug'],
                'entry' => $department['entry'],
                'meta_title' => $department['meta_title'],
                'img' => $department['img'],
            ]);

            $categories_department_id = $categories->whereIn('slug', $department['categories'])->pluck('id')->values();

            $department_model->categories()->sync($categories_department_id);
        }

        //blog
        Category::factory()->count(5)->create([
            'type' => 'blog'
        ]);
    }
}
