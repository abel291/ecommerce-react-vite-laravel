<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::truncate();
        $brands = [
            'fury',
            'logitech',
            'cooler master',
            'asus',
            'corsair',
            'apple',
            'intel',
            'adata',
            'hp',
            'ryzen',

        ];
        $data = [];
        foreach ($brands as $key => $value) {
            $data[$key] = [
                'name' => ucfirst($value),
                'slug' => Str::slug($value),
                'img' => Str::slug($value) . '.png',
            ];
        }

        Brand::insert($data);
    }
}
