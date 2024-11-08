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
        $sizes = Size::pluck('id', 'name');
        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));
        $sku_id = 1;
        $skus_array = [];
        foreach ($products as $product) {

            foreach ($product['variants'] as $variant) {

                foreach ($product['sizes'] as $size) {
                    // stockEntry
                    $stock = rand(1, 5) * 12;
                    array_push($skus_array, [
                        'id' => $sku_id,
                        'product_id' => $variant['id'],
                        'size_id' => $sizes[$size],
                        'stock' => $stock,
                    ]);
                    $sku_id++;
                }
            }
            if (count($skus_array) > 200) {
                Sku::insert($skus_array);
                $skus_array = [];
                $this->command->info($sku_id);
            }
        }
        Sku::insert($skus_array);
    }
}
