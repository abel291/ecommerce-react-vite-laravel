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

        if (config('app.env') == 'testing') {
            User::factory()->count(10)->create()
                ->each(function (User $user) {
                    $user->assignRole('client');
                });
        } else {

            for ($i = 0; $i < 100; $i++) {

                $date = fake()->dateTimeInInterval('-12 month', 'now');

                $user = User::factory()->make();
                $days = rand(1, 360);
                $created_at = Carbon::now()->subDays($days);
                $user->created_at = $created_at;
                $user->updated_at = $created_at;
                $user->save(['timestamps' => false]);
                $user->assignRole('client');
            }
        }
    }
}
