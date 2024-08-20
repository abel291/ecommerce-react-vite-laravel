<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresentationResource extends JsonResource
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
            'code' => $this->code,
            'stock' => boolval($this->stock),
            'default' => $this->default,
            'color' => new ColorAttributeResource($this->whenLoaded('color')),
            'size' => new SizeAttributeResource($this->whenLoaded('size')),
        ];
    }
}
