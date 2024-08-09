<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'position' => $this->faker->jobTitle(),
            'bio' => $this->faker->realText($maxNbChars = 500),
            'img' => '/img/authors/author-' . rand(1, 10) . '.jpg',
            'social1' => $this->faker->url(),
            'social2' => $this->faker->url(),
        ];
    }
}
