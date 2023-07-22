<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
		Role::truncate();
		Role::create(['name' => 'admin']);
		Role::create(['name' => 'customer']);

		$user = User::factory()->create([
			'email' => 'user@user.com',
		]);
		$user->assignRole('admin');

		$users = User::factory()->count(200)->create();
		foreach ($users as $key => $user) {
			$user->assignRole('customer');
		}
	}
}
