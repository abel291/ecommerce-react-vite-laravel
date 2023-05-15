<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
		$categories = Category::factory()->count(30)->create([
			'type' => 'blog',
			'specifications' => []
		]);
		$author = Author::factory()->count(30)->create();
		Blog::factory()
			->count(30)
			->create([
				'author_id' => $author->random()->id,
				'category_id' => $categories->random()->id,

			]);
	}
}
