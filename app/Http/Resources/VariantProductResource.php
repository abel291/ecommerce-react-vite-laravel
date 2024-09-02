<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantProductResource extends JsonResource
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
            'ref' => $this->ref,
            'thumb' => $this->thumb,
            'img' => $this->img,
            'images' => $this->whenLoaded('images'),
            'old_price' => $this->old_price,
            'offer' => $this->offer,
            'price' => $this->price,
            'max_quantity' => $this->max_quantity,
            'color' => new ColorResource($this->whenLoaded('color')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
