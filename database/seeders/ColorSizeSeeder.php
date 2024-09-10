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

        $colors = collect(Storage::json('products/colors.json'))->values();
        foreach ($colors as $color) {
            Color::create($color);
        }
        // Color::insert($colors);

        $sizes = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->pluck('sizes')->collapse()->unique()
            ->filter()
            ->values();
        // dd($sizes);

        foreach ($sizes as $size) {
            Size::create([
                'name' => $size,
                'slug' => Str::slug($size),
            ]);
        }
        // Size::insert($sizes);
    }
}
