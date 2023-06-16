<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PagesTest extends TestCase
{
	use DatabaseTransactions;

	public function test_can_view_pages(): void
	{
		$pages = [
			'home',
			'offers',
			'combos',
			'assemblies',
			'contact',
			'search',
			'blog'
		];

		foreach ($pages as $page) {
			//echo "$page------\n";
			$response = $this->get(route($page));
			$response->assertStatus(200);
		}
	}

	public function test_can_view_page_product(): void
	{
		$product = Product::get()->random();
		$response = $this->get(route('product', $product->slug));
		$response->assertStatus(200)->assertInertia(fn (AssertableInertia  $page) => $page
			->component('Product/Product'));
	}
}
