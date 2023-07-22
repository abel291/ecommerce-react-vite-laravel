<?php

namespace App\Http\Resources\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryFilterResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			//'id' => $this->id,
			'name' => $this->name,
			'slug' => $this->slug,
			'selected' => $this->selected,
			'products_count' => $this->products_count,
		];
	}
}
