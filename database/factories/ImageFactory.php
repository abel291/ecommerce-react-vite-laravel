<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'alt' => $this->faker->words(7, true),
            'img' => 'item-'.rand(1, 52).'.jpg',
            'sort' => rand(1, 10),
            'title' => $this->faker->words(7, true),
            'active' => 1,
        ];
    }
}
