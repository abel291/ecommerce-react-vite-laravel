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
            'variantId' => $this->id,
            'ref' => $this->ref,
            'default' => $this->default,
            'thumb' => $this->thumb,
            'img' => $this->img,
            'images' => $this->whenLoaded('images'),
            'color' => new ColorResource($this->whenLoaded('color')),
            'sizes' => VariantSizeResource::collection($this->whenLoaded('sizes')),

            //product
            'productId' => $this->product->name,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'entry' => $this->product->entry,
            'description' => $this->product->description,
            'old_price' => $this->product->old_price,
            'offer' => $this->product->offer,
            'price' => $this->product->price,
            'max_quantity' => $this->product->max_quantity,
            'variants' => VariantResource::collection($this->whenLoaded('product.variants')),
            'specifications' => $this->whenLoaded('product.specifications'),
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'category' => $this->whenLoaded('product.category'),
            'department' => $this->whenLoaded('product.department'),
        ];
    }
}
