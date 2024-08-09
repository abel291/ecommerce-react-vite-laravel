<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::truncate();
        Author::truncate();
        Image::where('model_type', 'App\Models\Page')->delete();

        $authors = Author::factory()->count(rand(10, 20))->create();
        $categories = Category::where('type', 'blog')->select('id', 'name')->get();

        Blog::factory()->count(rand(10, 20))
            ->state(function (array $attributes) use ($authors, $categories) {
                $category = $categories->random();
                return [
                    'title' => $category->name . " " . fake()->sentence(),
                    'author_id' => $authors->random()->id,
                    'category_id' => $category->id,
                ];
            })->create();
    }
}
