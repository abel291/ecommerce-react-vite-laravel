<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'rowId' => $this['rowId'],
            'id' => $this['id'],
            'name' => $this['name'],
            'slug' => $this['slug'],
            'img' => $this['img'],
            'price' => $this['price'],
            'old_price' => $this['old_price'],
            'quantity' => $this['quantity'],
            'maxQuantity' => $this['max_quantity'],
            'total' => $this['total'],
            'attributes' => $this['attributes'],
        ];
    }
}
