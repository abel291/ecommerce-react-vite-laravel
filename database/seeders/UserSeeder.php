<?php

namespace Database\Seeders;

use App\Models\User;
use Faker as Faker;
use Illuminate\Database\Seeder;
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
		User::factory()->create([
			'email' => 'user@user.com',
		]);
	}
}
