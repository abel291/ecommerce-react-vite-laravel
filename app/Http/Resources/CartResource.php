<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
			'name' => $this->name,
			'price' => (float)$this->price,
			'quantity' => (int)$this->qty,
			'total' => $this->total(),
			'options' => $this->options,
			'model' => [
				'id' => $this->model->id,
				'slug' => $this->model->slug,
				'img' => $this->model->img,
				'maxQuantity' => $this->model->max_quantity,
				'price' => $this->model->price,
				'priceOffer' => $this->model->price_offer,
			],
		];
	}
}
