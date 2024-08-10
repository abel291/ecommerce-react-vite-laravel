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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description_min' => $this->description_min,
            'description_max' => $this->description_max,
            'img' => $this->img,
            'thumb' => $this->thumb,
            'old_price' => $this->old_price,
            'offer' => $this->offer,
            'price' => $this->price,
            'max_quantity' => $this->max_quantity,
            'skus' => $this->whenLoaded('skus'),
            'featured' => $this->featured,
            'specifications' => $this->whenLoaded('specifications'),
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'images' => $this->whenLoaded('images'),
            'category' => $this->whenLoaded('category'),
            'department' => $this->whenLoaded('department'),
            'brand' => $this->whenLoaded('brand'),
            'active' => $this->active,
        ];
    }
}
