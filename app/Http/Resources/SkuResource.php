<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
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
            'code' => $this->code,
            'default' => $this->default,
            'thumb' => $this->thumb,
            'img' => $this->img,
            'images' => $this->whenLoaded('images'),
            'color' => new ColorResource($this->whenLoaded('color')),
            'sizes' => SkuSizeResource::collection($this->whenLoaded('sizes')),
        ];
    }
}
