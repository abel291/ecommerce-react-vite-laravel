<?php

namespace App\Http\Resources;

use App\Models\Attribute\ColorAttribute;
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
            'entry' => $this->entry,
            'description' => $this->description,
            'specifications' => $this->whenLoaded('specifications'),
            'attributes' => AttributeResource::collection($this->whenLoaded('attributes')),
            'skus' => SkuResource::collection($this->whenLoaded('skus')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            // 'variant' => new VariantResource($this->whenLoaded('variant')),
            'category' => $this->whenLoaded('category'),
            'department' => $this->whenLoaded('department'),
            'brand' => $this->whenLoaded('brand'),
        ];
    }
}
