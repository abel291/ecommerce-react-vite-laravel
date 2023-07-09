<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Blog::truncate();
		Author::truncate();
		//
		$authors = Author::factory()->count(rand(10, 20))->create();
		$categories = Category::get();
		Blog::factory()->count(rand(10, 20))
			->create(fn () => [
				'author_id' => $authors->random()->id,
				'category_id' => $categories->random()->id,
			]);
	}
}
