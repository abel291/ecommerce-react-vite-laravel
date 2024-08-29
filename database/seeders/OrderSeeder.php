<?php

namespace Database\Seeders;

use App\Enums\CartEnum;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Presentation;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Number;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::truncate();
        OrderProduct::truncate();
        Payment::truncate();

        $users = User::get();
        $discountCodes = DiscountCode::get();
        foreach ($users->multiply(3) as $user) {

            $max_quantity_selected = rand(1, 10);
            $orderProducts = Presentation::where('stock', '>=', $max_quantity_selected)
                ->with('product:id,slug,img,name,price,offer,old_price,max_quantity', 'color:id,name', 'size:id,name')
                ->limit(rand(2, 5))
                ->inRandomOrder()
                ->get()->map(function ($presentation) use ($max_quantity_selected) {
                    $quantity = rand(1, $max_quantity_selected);
                    return OrderService::formatOrderProduct($presentation, $quantity);
                });


            if (rand(0, 2) == 0) {
                $discountCode = $discountCodes->random();
            } else {
                $discountCode = null;
            }

            $order = OrderService::generateOrder($orderProducts, $discountCode, $user);

            $order->created_at = fake()->dateTimeBetween('-12 months');

            $order->updated_at = $order->created_at;

            $order->save();

            $order->order_products()->createMany($orderProducts);

            Payment::factory()->create([
                'order_id' => $order->id
            ]);

            $this->command->info("Orden " . $order->code . " : " . Number::currency($order->total));
        }
    }
}
