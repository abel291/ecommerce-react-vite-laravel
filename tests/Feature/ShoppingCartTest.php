<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ShoppingCartSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
	use RefreshDatabase;
	/**
	 * A basic feature test example.
	 */
	public function test_shopping_cart_empty_page_is_displayed(): void
	{

		$user = User::factory()->create();

		$response = $this
			->actingAs($user)
			->get(route('shopping-cart.index'))
			->assertInertia(fn (AssertableInertia  $page) => $page
				->component('ShoppingCart/ShoppingCart'));

		$response->assertOk();
	}

	public function test_shopping_cart_add_products(): void
	{
		$products = Product::factory(10)->has(Stock::factory()->count(1))->create();
		$user = User::factory()->create();
		foreach ($products as $key => $item) {

			$response = $this
				->actingAs($user)
				->post(route('shopping-cart.store'), [
					'quantity' => 1,
					'product_id' => $item->id
				]);

			$response->assertRedirect(route('shopping-cart.index'));
			$response->assertValid();
		}
	}

	public function test_shopping_cart_remove_product(): void
	{
		$products = Product::factory(10)->has(Stock::factory()->count(1))->create();
		$user = User::factory()->create();
		foreach ($products as $key => $item) {
			$response = $this
				->actingAs($user)
				->post(route('shopping-cart.store'), [
					'quantity' => 1,
					'product_id' => $item->id
				]);

			$response->assertRedirect(route('shopping-cart.index'));
			$response->assertValid();
		}

		$response = $this
			->actingAs($user)
			->delete(route('shopping-cart.destroy', $products->random()->id));
	}
}
