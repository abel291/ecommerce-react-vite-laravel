<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'default' => $this->default,
            'thumb' => $this->thumb,
            'img' => $this->img,
            'images' => $this->whenLoaded('images'),
            'color' => new ColorResource($this->whenLoaded('color')),
            'sizes' => VariantSizeResource::collection($this->whenLoaded('sizes')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
