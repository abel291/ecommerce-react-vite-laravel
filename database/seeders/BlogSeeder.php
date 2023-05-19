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
		// 
		$categories = Category::factory()->count(10)->create([
			'type' => 'blog',
			'specifications' => []
		]);
		$this->command->info('categories created');

		$authors = Author::factory()->count(10)->create();
		$this->command->info('authors created');

		Blog::factory()
			->count(10)
			->state(
				fn () => [
					'category_id' => $categories->random()->id,
					'author_id' => $authors->random()->id,
				]
			)->create();
	}
}
