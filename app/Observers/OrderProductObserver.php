<?php

namespace App\Observers;

use App\Models\OrderProduct;

class OrderProductObserver
{
    /**
     * Handle the OrderProduct "created" event.
     */
    public function created(OrderProduct $orderProduct): void
    {

        if ($orderProduct->order_id == null) {
            $orderProduct->user->shopping_cart_count = $orderProduct->user->shoppingCart()->count();
            $orderProduct->user->save();
        }
    }

    /**
     * Handle the OrderProduct "updated" event.
     */
    public function updated(OrderProduct $orderProduct): void
    {
        if ($orderProduct->order_id == null) {
            $orderProduct->user->shopping_cart_count = $orderProduct->user->shoppingCart()->count();
            $orderProduct->user->save();
        }
    }

    /**
     * Handle the OrderProduct "deleted" event.
     */
    public function deleted(OrderProduct $orderProduct): void
    {
        if ($orderProduct->order_id == null) {
            $orderProduct->user->shopping_cart_count = $orderProduct->user->shoppingCart()->count();
            $orderProduct->user->save();
        }
    }

    /**
     * Handle the OrderProduct "restored" event.
     */
    public function restored(OrderProduct $orderProduct): void
    {
    }

    /**
     * Handle the OrderProduct "force deleted" event.
     */
    public function forceDeleted(OrderProduct $orderProduct): void
    {
    }
}
