<?php

namespace App\Http\Resources;

use App\Models\Attribute\ColorAttribute;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardResource extends JsonResource
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
            'ref' => $this->ref,
            'thumb' => $this->thumb,
            'old_price' => $this->old_price,
            'offer' => $this->offer,
            'price' => $this->price,
            'color_id' => $this->color_id,
            // 'color' => new ColorResource($this->color),
            'colors' => ColorResource::collection($this->product->variants->pluck('color')),

        ];
    }
}
