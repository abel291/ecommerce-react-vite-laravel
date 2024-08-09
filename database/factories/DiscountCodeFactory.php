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

        //$type = $this->faker->randomElement(['amount', 'percent']);
        $type = DiscountCodeTypeEnum::PERCENT;

        if ($type == DiscountCodeTypeEnum::FIXED) {
            $value = rand(10, 200) * 1000;
        } else {
            $value = rand(1, 19) * 5;
        }

        return [
            'name' => $this->faker->sentence(2),
            'entry' => $this->faker->sentence(),
            'code' => $this->faker->regexify('[A-Z]{5}[0-9]{3}'),
            'type' => $type,
            'value' => $value,
            'active' => 1,
            'max_uses' => rand(1, 10),
            'times_used' => rand(10, 30),
            'valid_from' => now(),
            'valid_to' => $this->faker->dateTimeInInterval('+10 month', '+24 month'),
        ];
    }
}
