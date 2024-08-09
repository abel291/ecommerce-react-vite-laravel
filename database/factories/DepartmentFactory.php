<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence();
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'img' => '',
            'meta_title' => $name,
            'entry' => $this->faker->text(),
            'active' => 1,
        ];
    }
}
