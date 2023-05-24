<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'code' => $this->code,
			'quantity' => $this->quantity,
			'shipping' => $this->shipping,
			'status' => $this->status,
			'sub_total' => $this->sub_total,
			'tax_amount' => $this->tax_amount,
			'tax_percent' => $this->tax_percent,
			'products' => $this->whenLoaded('order_products'),
			'total' => $this->total,
			'user' => $this->user_data,
			'created_at' => $this->created_at->format('Y/m/d'),
		];
	}
}
