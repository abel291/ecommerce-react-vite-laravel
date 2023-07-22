<?php

namespace App\Observers;

use App\Models\AttributeValue;
use App\Models\OrderProduct;

class OrderProductObserver
{
	/**
	 * Handle the OrderProduct "created" event.
	 */
	public function created(OrderProduct $orderProduct): void
	{
		// if ($orderProduct->attributes) {
		// 	foreach ($orderProduct->attributes as $attributeSlug => $attributeValueSlug) {
		// 		AttributeValue::where('product_id', $orderProduct->product_id)
		// 			->where('slug', $attributeValueSlug)->whereHas('attribute', function ($query) use ($attributeSlug) {
		// 				$query->where('slug', $attributeSlug);
		// 			})
		// 			->decrement('quantity', $orderProduct->quantity);
		// 	}
		// }
	}

	/**
	 * Handle the OrderProduct "updated" event.
	 */
	public function updated(OrderProduct $orderProduct): void
	{
	}

	/**
	 * Handle the OrderProduct "deleted" event.
	 */
	public function deleted(OrderProduct $orderProduct): void
	{
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
