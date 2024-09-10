<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
        Role::create(['name' => 'client']);

        $user = User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $user->assignRole('admin');

        User::factory()->count(100)->create([
            'created_at' => fake()->dateTimeBetween('-12 month')
        ])
            ->each(function (User $user) {
                $user->assignRole('client');
            });
    }
}
