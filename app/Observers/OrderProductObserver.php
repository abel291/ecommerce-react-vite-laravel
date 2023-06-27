<?php

namespace App\Observers;

use App\Enums\PaymentStatus;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Cache;

class OrderProductObserver
{
	/**
	 * Handle the OrderProduct "created" event.
	 */
	public function created(OrderProduct $orderProduct): void
	{
		Cache::forget('shoppingCart');
	}

	/**
	 * Handle the OrderProduct "updated" event.
	 */
	public function updated(OrderProduct $orderProduct): void
	{
		Cache::forget('shoppingCart');
	}

	/**
	 * Handle the OrderProduct "deleted" event.
	 */
	public function deleted(OrderProduct $orderProduct): void
	{
		Cache::forget('shoppingCart');
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
		dd("deleted");
	}
}
