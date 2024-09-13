<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

class ProductService
{
    public static function generateRef($parent_id, $color_id)
    {

        $parent_product_id = Str::padLeft($parent_id, 4, '0');

        return $parent_product_id . '-' . Str::padLeft($color_id, 3, '0');

    }

    public static function charger(User $user, Order $order, string $payment_method_id): object
    {
        $total = (int) ($order->total * 100);

        return $user->charge($total, $payment_method_id, [
            'metadata' => [
                'order_code' => $order->code,
                'quantity_products' => $order->quantity,
            ],
            'currency' => 'cop',
            'description' => "Compra Por internet $order->code - $user->email",
        ]);
    }
}
