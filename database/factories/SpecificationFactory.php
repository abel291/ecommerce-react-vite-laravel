<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specification>
 */
class SpecificationFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		$name = $this->faker->word();
		return [
			'name' => $name,
			'slug' => Str::slug($name),
			'value' => $this->faker->words(3, true),
			'active' => 1
		];
	}
}
