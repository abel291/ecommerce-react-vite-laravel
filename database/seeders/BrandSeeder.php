<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Brand;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
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
        Brand::factory()->create([
            'name' => 'no brand',
            'slug' => 'no-brand',
            'img' => '',
        ]);
    }
}
