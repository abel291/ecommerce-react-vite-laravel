<?php

namespace Database\Seeders;

use App\Models\User;
use Faker as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
		$user = User::factory()->create([
			'email' => 'user@user.com',
		]);
		Role::create(['name' => 'admin']);
		Role::create(['name' => 'usuario']);
		$user->assignRole('admin');

		$users = User::factory()->count(200)->create();
		foreach ($users as $key => $user) {
			$user->assignRole('usuario');
		}
	}
}
