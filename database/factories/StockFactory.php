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

        return [
            'quantity' => rand(40, 50),
            'remaining' => rand(10, 50),
            'supplier' => $this->faker->words(7, true),
            'barcode' => $this->faker->ean8(),
        ];
    }
}
