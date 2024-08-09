<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => ucfirst($this->faker->sentence()),
            'slug' => Str::slug($this->faker->sentence()),
            'meta_title' => ucfirst($this->faker->words(2, true)),
            'meta_desc' => $this->faker->sentence(),
            'img' => '/img/blog/post-' . rand(1, 10) . '.jpg',
            'thum' => '/img/blog/post-' . rand(1, 10) . '.jpg',
            'entry' => $this->faker->paragraph(),
            'desc' => $this->faker->text(800),
            'active' => 1,

        ];
    }
}
