<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Storage;

class ColorSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::truncate();
        Size::truncate();

        $colors = collect(Storage::json('products/colors.json'))->values()->toArray();
        Color::insert($colors);

        $sizes = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->pluck('sizes')->collapse()->unique()
            ->map(function ($size) {
                return [
                    'name' => $size,
                    'slug' => Str::slug($size),
                ];
            })->toArray();
        Size::insert($sizes);
    }
}
