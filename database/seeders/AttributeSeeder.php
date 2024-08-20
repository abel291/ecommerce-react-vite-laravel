<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
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
        ColorAttribute::truncate();
        SizeAttribute::truncate();

        $colors = [];
        $sizes = [];

        $attributes = collect(Storage::json(DatabaseSeeder::getPathProductJson()))
            ->pluck('attributes')
            ->collapse()->groupBy('name')->map(function ($attribute, $attribute_name) {

                $attribute = $attribute->pluck('value')->collapse()->unique();

                switch ($attribute_name) {
                    case 'Color':
                        $attribute_values = $attribute->map(function ($value) {
                            return [
                                'name' => $value,
                                'hex' => fake()->hexColor(),
                                'slug' => Str::slug($value)
                            ];
                        });
                        break;

                    case 'Talla':
                        $attribute_values = $attribute->map(function ($value) {
                            return [
                                'name' => $value,
                                'slug' => Str::slug($value)
                            ];
                        });

                    default:

                        break;
                }
                return $attribute_values;
            })->toArray();

        foreach ($attributes as  $attribute_name => $attribute_value) {

            match ($attribute_name) {
                'Color' => ColorAttribute::insert($attribute_value),
                'Talla' => SizeAttribute::insert($attribute_value),
            };
        }
    }
}
