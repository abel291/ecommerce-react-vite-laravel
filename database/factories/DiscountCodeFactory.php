<?php

namespace Database\Factories;

use App\Enums\DiscountCodeTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountCodeFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{

		$start_date = $this->faker->dateTimeInInterval('now', '+1 month');
		$end_date = $this->faker->dateTimeInInterval('+2 month', '+10 month');

		//$type = $this->faker->randomElement(['amount', 'percent']);
		$type = DiscountCodeTypeEnum::PERCENT;
		if ($type == DiscountCodeTypeEnum::FIXED) {
			$value = rand(10, 200) * 1000;
		} else {
			$value = rand(1, 90);
		}

		return [
			"name" => $this->faker->sentence(2),
			"entry" => $this->faker->sentence(),
			'code' => $this->faker->regexify('[A-Z]{5}[0-9]{3}'),
			'type' => $type,
			'value' => $value,
			"active" => 1,
			"start_date" => $start_date,
			"end_date" => $end_date,
		];
	}
}
