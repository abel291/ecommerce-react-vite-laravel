<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{

		return [
			'price' => $this->price,
			'quantity' => $this->quantity,
			'total' => $this->total,
			'data' => $this->data,
			'attributes' => $this->attributes,
		];
	}
}
