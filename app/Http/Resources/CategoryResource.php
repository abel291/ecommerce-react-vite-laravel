<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'banner' => $this->banner,
            'img' => $this->img,
            'entry' => $this->entry,
            'active' => $this->active,
            'in_home' => $this->in_home,
        ];
    }
}
