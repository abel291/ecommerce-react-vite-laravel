<?php

use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Services\OrderService;
use Database\Seeders\CategorySeeder;

test('profile page is displayed', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->get(route('profile.index'));

    $response->assertOk();
});
test('profile orders page is displayed', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->get(route('profile.orders'));

    $response->assertOk();
});
test('profile order details page is displayed', function () {

    $this->seed();
    $user = User::first();
    $order = $user->orders->first();
    $response = $this
        ->actingAs($user)
        ->get(route('profile.order', $order->code));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->patch(route('profile.account-details.update'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_confirmation' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.account-details'));

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

// test('email verification status is unchanged when the email address is unchanged', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->patch('/profile', [
//             'name' => 'Test User',
//             'email' => $user->email,
//         ]);

//     $response
//         ->assertSessionHasNoErrors()
//         ->assertRedirect('/profile');

//     $this->assertNotNull($user->refresh()->email_verified_at);
// });

// test('user can delete their account', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->delete('/profile', [
//             'password' => 'password',
//         ]);

//     $response
//         ->assertSessionHasNoErrors()
//         ->assertRedirect('/');

//     $this->assertGuest();
//     $this->assertNull($user->fresh());
// });

// test('correct password must be provided to delete account', function () {
//     $user = User::factory()->create();

//     $response = $this
//         ->actingAs($user)
//         ->from('/profile')
//         ->delete('/profile', [
//             'password' => 'wrong-password',
//         ]);

//     $response
//         ->assertSessionHasErrors('password')
//         ->assertRedirect('/profile');

//     $this->assertNotNull($user->fresh());
// });
