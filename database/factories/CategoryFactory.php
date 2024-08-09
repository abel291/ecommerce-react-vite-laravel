<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Category::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$name = $this->faker->words(2, true);

		return [
			'name' => ucfirst($name),
			'slug' => Str::slug($name),
			'img' => '',
			'entry' => $this->faker->text(250),
			'active' => 1,
			'type' => 'product',
			//'specifications' => [],
		];
	}
}
