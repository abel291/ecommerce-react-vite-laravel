<?php

namespace Database\Seeders;

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
		$categories = Category::factory()->count(30)->create([
			'type' => 'blog',
			'specifications' => null
		]);

		for ($i = 0; $i < 30; $i++) {
			$post = Blog::factory()->create();
			$post->categories()->sync($categories->random(3)->pluck('id'));
		}
	}
}
