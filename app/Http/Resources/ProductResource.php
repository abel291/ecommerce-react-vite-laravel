<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' 				=> $this->id,
			'name' 				=> $this->name,
			'slug' 				=> $this->slug,
			'description_min' 	=> $this->description_min,
			'description_max' 	=> $this->description_max,
			'img' 				=> $this->img,
			'price' 			=> $this->price,
			'offer' => $this->offer,
			'price_offer' => $this->price_offer,
			'max_quantity' => $this->max_quantity,
			'stock' => $this->stock,
			'featured' => $this->featured,
		];
	}
}
