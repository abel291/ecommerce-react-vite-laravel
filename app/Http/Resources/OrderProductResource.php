<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'ref' => $this->ref,
            'thumb' => $this->thumb,
            'color' => $this->color,
            'size' => $this->size,
            'old_price' => $this->old_price,
            'offer' => $this->offer,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
        ];
    }
}
