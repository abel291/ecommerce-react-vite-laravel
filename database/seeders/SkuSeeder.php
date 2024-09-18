<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
use App\Models\AttributeOption;
use App\Models\AttributeValue;
use App\Models\Color;
use App\Models\Image;
use App\Models\Size;
use App\Models\Sku;
use App\Models\StockEntry;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Sku::truncate();
        StockEntry::truncate();

        $sizes = Size::pluck('id', 'name');
        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));
        $sku_id = 1;
        $skus_array = [];
        $stock_array = [];
        $user_id = User::select('id')->get()->random()->id;
        foreach ($products as $product) {
            foreach ($product['variants'] as $variant) {

                foreach ($product['sizes'] as $size) {

                    // stockEntry
                    $stock = 0;
                    for ($i = 0; $i < rand(4, 10); $i++) {
                        # code...
                        $quantity = rand(1, 5) * 12;
                        $stock += $quantity;
                        $stock_array[] = [
                            'quantity' => $quantity,
                            'cost' => round($product['price'] * 0.80, 2),
                            'user_id' => $user_id,
                            'sku_id' =>  $sku_id,
                            'created_at' => fake()->dateTimeBetween('-2 month', 'now'),
                            'updated_at' => fake()->dateTimeBetween('-2 month', 'now'),
                        ];
                    }
                    array_push($skus_array, [
                        'id' => $sku_id,
                        'product_id' => $variant['id'],
                        'size_id' => $sizes[$size],
                        'stock' => $stock,
                    ]);
                    $sku_id++;
                }
            }
            if (count($skus_array) > 100) {
                shuffle($stock_array);
                Sku::insert($skus_array);
                StockEntry::insert($stock_array);
                $skus_array = [];
                $stock_array = [];
                // $this->command->info($sku_id);
            }
        }
        shuffle($stock_array);
        Sku::insert($skus_array);
        StockEntry::insert($stock_array);
    }
}
