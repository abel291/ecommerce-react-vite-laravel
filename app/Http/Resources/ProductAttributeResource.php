<?php

namespace App\Http\Resources;

use App\Http\Resources\AttributeValueResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'attribute' => new AttributeResource($this->whenLoaded('attribute')),
			'attribute_values' => AttributeValueResource::collection($this->whenLoaded('attribute_values')),
		];
	}
}
