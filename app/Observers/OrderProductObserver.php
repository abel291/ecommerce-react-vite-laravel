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
		$orderProduct->product->stock()->decrement('remaining', $orderProduct->quantity);
	}

	/**
	 * Handle the OrderProduct "updated" event.
	 */
	public function updated(OrderProduct $orderProduct): void
	{
		//
	}

	/**
	 * Handle the OrderProduct "deleted" event.
	 */
	public function deleted(OrderProduct $orderProduct): void
	{
		//
	}

	/**
	 * Handle the OrderProduct "restored" event.
	 */
	public function restored(OrderProduct $orderProduct): void
	{
		//
	}

	/**
	 * Handle the OrderProduct "force deleted" event.
	 */
	public function forceDeleted(OrderProduct $orderProduct): void
	{
		//
	}
}
