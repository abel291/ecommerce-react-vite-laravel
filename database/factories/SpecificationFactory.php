<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SpecificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Specification::class;

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
            'name_slug' => Str::slug($name),
        ];
    }
}
