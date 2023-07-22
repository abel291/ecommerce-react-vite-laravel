<?php

namespace App\Http\Resources\Search;

use App\Http\Resources\Search\CategoryFilterResource;
use App\Http\Resources\Search\AttributeFilterResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'departments' => CategoryFilterResource::collection($this->departments),
			'categories' => CategoryFilterResource::collection($this->categories),
			'attributes' => AttributeFilterResource::collection($this->attributes),
		];
	}
}
