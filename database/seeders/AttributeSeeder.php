<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeValue;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Storage;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::truncate();
        AttributeValue::truncate();

        $attributes = collect(Storage::json(DatabaseSeeder::getPathProductJson()))
            ->pluck('attributes')
            ->collapse()
            ->groupBy('name')->map(function ($attribute) {

                $attribute_values = $attribute->pluck('value')->collapse()->unique()->map(function ($value) {
                    return [
                        'name' => $value,
                        // 'slug' => Str::slug($value)
                    ];
                })->values();
                return $attribute_values;
            });

        foreach ($attributes as $name_attribute => $attribute_values) {
            $attribute = Attribute::create([
                'name' => $name_attribute,
                // 'slug' => Str::slug($name_attribute),
            ]);
            $attribute->attribute_values()->createMany($attribute_values);
        }
    }
}
