<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $faker = Faker\Factory::create();
        User::create([
            'name' => 'Gregoria Soriano',
            'email' => 'example@exmaple.com',
            'password' => Hash::make('123123'),
            'phone' => $faker->phoneNumber,
            'country' => str_replace(["'", '"'], '', $faker->country),
            'city' => str_replace(["'", '"'], '', $faker->city),

        ]);
    }
}
