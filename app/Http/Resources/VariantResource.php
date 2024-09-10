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
        // dd($this->inStock);
        return [
            'id' => $this->id,
            'ref' => $this->ref,
            'default' => $this->default,
            'thumb' => $this->thumb,
            'img' => $this->img,
            'stock' => $this->whenHas('stock'),
            'images' => $this->whenLoaded('images'),
            'color' => new ColorResource($this->whenLoaded('color')),
            'skus' => SkuResource::collection($this->whenLoaded('skus')),
            'sizes' => VariantSizeResource::collection($this->whenLoaded('sizes')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
