<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	public function test_dashboard_user_lists(): void
	{
		$this->seed();

		$user = User::factory()->create();
		$user->assignRole('admin');

		$response = $this->actingAs($user)->get(route('dashboard.users'));

		$response->assertStatus(200);
	}
}
