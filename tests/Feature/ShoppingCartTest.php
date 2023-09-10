<?php

namespace Tests\Feature;

use App\Enums\CartEnum;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_shopping_cart_empty_page_is_displayed(): void
    {

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('shopping-cart.index'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('ShoppingCart/ShoppingCart'));

        $response->assertOk();
    }
    public function test_shopping_cart_page_is_full_cart(): void
    {
        $this->seed();
        $products = Product::get()->random(10);
        $user = User::factory()->create();
        foreach ($products as  $product) {
            $options['attributes'] = [];
            CartService::add(CartEnum::SHOPPING_CART->value, $product, 5, $options);
        }


        $response = $this
            ->actingAs($user)
            ->get(route('shopping-cart.index'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('ShoppingCart/ShoppingCart'));

        $response->assertOk();
    }

    public function test_shopping_cart_error_quantity_in_stock(): void
    {
        $max_quantity = config('shopping-cart.max-quantity');

        $products = Product::factory(10)
            ->has(
                Stock::factory()->state([
                    'quantity' => $max_quantity * 2,
                    'remaining' => $max_quantity * 2,

                ])->count(1)
            )
            ->create([
                'max_quantity' => $max_quantity * 2
            ]);

        CartService::add(CartEnum::SHOPPING_CART->value, $products->random(), $max_quantity, ['attributes' => []]);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('shopping-cart.store'), [
                'quantity' => 1,
                'product_id' => $products->random()->id,
                'attributes' => []
            ]);

        $response->assertInvalid(['quantity']);
    }



    public function test_shopping_cart_add_products(): void
    {
        $products = Product::factory(10)->has(Stock::factory()->state([
            'quantity' => 10,
            'remaining' => 10,
        ])->count(1))->create();

        $user = User::factory()->create();
        foreach ($products as  $item) {

            $response = $this
                ->actingAs($user)
                ->post(route('shopping-cart.store'), [
                    'quantity' => 1,
                    'product_id' => $item->id,
                    'attributes' => []
                ]);

            $response->assertRedirect(route('shopping-cart.index'));
            $response->assertValid();
        }
    }

    public function test_shopping_cart_remove_product(): void
    {
        $products = Product::factory(10)->has(Stock::factory()->state([
            'quantity' => 10,
            'remaining' => 10,
        ])->count(1))->create();
        $user = User::factory()->create();
        foreach ($products as  $item) {
            $response = $this
                ->actingAs($user)
                ->post(route('shopping-cart.store'), [
                    'quantity' => 1,
                    'product_id' => $item->id,
                    'attributes' => []
                ]);

            $response->assertRedirect(route('shopping-cart.index'));
            $response->assertValid();
        }

        $response = $this
            ->actingAs($user)
            ->delete(route('shopping-cart.destroy', $products->random()->id));
    }
}
