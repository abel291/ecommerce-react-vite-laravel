<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public static $order = 1;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(7, true);
        $priceDefault = rand(10, 1500);
        $price = 0;
        $offer = $this->faker->randomElement([null, 10, 20, 30, 40, 50]);

        if ($offer) {
            $price = $priceDefault - ($priceDefault * ($offer / 100));
        } else {
            $price = $priceDefault;
        }

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description_min' => $this->faker->paragraph(),
            'description_max' => $this->faker->text(800),
            'price_default' => $priceDefault,
            'offer' => $offer,
            'price' => $price,
            'img' => 'item-'.rand(1, 52).'.jpg',
            'featured' => rand(0, 1),
            'availables' => rand(10, 300),
            'brand_id' => Brand::inRandomOrder()->first()->id,

        ];
    }
}
