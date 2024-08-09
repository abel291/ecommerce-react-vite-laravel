<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::where('model_type', 'App\Models\Product')->delete();

        $products_images = collect(Storage::json(env('DB_FAKE_PRODUCTS')))->pluck('images', 'id');
    }
}
