<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
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
			'slug' => $this->slug,
			'qunatity' => $this->qunatity,
			'in_stock' => $this->in_stock,
			'default' => $this->default,
			'products_count' => $this->when($this->products_count, $this->products_count),
			'selected' => $this->when($this->selected, (bool)$this->selected),
			'attribute' => new AttributeResource($this->whenLoaded('attribute')),
		];
	}
}
