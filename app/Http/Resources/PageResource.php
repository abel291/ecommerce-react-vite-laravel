<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'meta_title' => $this->meta_title,
            'meta_desc' => $this->meta_desc,
            'data' => $this->data,
            'banners' => ImageResource::collection($this->whenLoaded('banners')),
        ];
    }
}
