<?php

namespace Database\Seeders;

use App\Enums\StockMovementOperationEnum;
use App\Models\Product;
use App\Models\Sku;
use App\Models\StockAdjustment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skus = Sku::pluck('id');
        $users = User::select('id')->get();
        StockAdjustment::truncate();
        $stock_adjustment_array = [];
        foreach ($skus as $key => $sku_id) {
            for ($i = 0; $i < rand(5, 20); $i++) {
                $stock_adjustment_array[] = [
                    'quantity' => rand(1, 6) * 12,
                    'note' => fake()->sentence(),
                    'type' => fake()->randomElement(StockMovementOperationEnum::cases()),
                    'user_id' => $users->random()->id,
                    'sku_id' => $sku_id,
                    'created_at' => fake()->dateTimeBetween('-2 month', 'now'),
                    'updated_at' => fake()->dateTimeBetween('-2 month', 'now'),
                ];
            }
            if (count($stock_adjustment_array) > 500) {
                shuffle($stock_adjustment_array);
                StockAdjustment::insert($stock_adjustment_array);
                $stock_adjustment_array = [];
                $this->command->info($key);
            }
        }
        shuffle($stock_adjustment_array);
        StockAdjustment::insert($stock_adjustment_array);
    }
}
