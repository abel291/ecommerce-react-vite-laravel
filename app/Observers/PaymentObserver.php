<?php

namespace App\Observers;

use App\Enums\PaymentStatus;
use App\Models\Payment;

class PaymentObserver
{
	/**
	 * Handle the Payment "created" event.
	 */
	public function created(Payment $payment): void
	{
		$payment->load('order.order_products', 'order.order_products.product');
		foreach ($payment->order->order_products as $item) {
			if ($payment->status == PaymentStatus::SUCCESSFUL) {
				$item->product->stock()->decrement('remaining', $item->quantity_selected);
			}
		}
	}

	/**
	 * Handle the Payment "updated" event.
	 */
	public function updated(Payment $payment): void
	{
		//
	}

	/**
	 * Handle the Payment "deleted" event.
	 */
	public function deleted(Payment $payment): void
	{
		//
	}

	/**
	 * Handle the Payment "restored" event.
	 */
	public function restored(Payment $payment): void
	{
		//
	}

	/**
	 * Handle the Payment "force deleted" event.
	 */
	public function forceDeleted(Payment $payment): void
	{
		//
	}
}
