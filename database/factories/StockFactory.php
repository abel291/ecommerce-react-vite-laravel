<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$stock = rand(500, 1000);
		return [
			'quantity' => $stock,
			'remaining' => $stock,
			'supplier' => $this->faker->words(7, true),
			'barcode' => $this->faker->bothify('?#?#?#?#?'),
		];
	}
}
