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
			'specifications' => []
		]);
		Blog::factory()
			->count(30)
			->hasAttached($categories->random(2))
			->create();
	}
}
