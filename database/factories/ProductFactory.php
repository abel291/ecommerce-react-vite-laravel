<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
	public static $order = 1;

	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Product::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$name = $this->faker->words(7, true);

		$price = rand(10, 1500);

		$offer = $this->faker->randomElement([0, 10, 20, 30, 40, 50]);

		$price_offer = $price - ($price * ($offer / 100));

		return [
			'name' => ucfirst($name),
			'slug' => Str::slug($name),
			'description_min' => $this->faker->paragraph(),
			'description_max' => $this->faker->text(800),
			'price' => $price,
			'offer' => $offer,
			'price_offer' => $price_offer,
			'img' => 'item-' . rand(1, 52) . '.jpg',
			'featured' => rand(0, 1),
			'stock' => rand(10, 300),
			'max_quantity' => rand(10, 40),
			'brand_id' => Brand::inRandomOrder()->first()->id,
		];
	}
}
