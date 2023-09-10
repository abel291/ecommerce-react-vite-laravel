<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'quantity' => $this->quantity,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'tax_rate' => $this->tax_rate,
            'tax_value' => $this->tax_value,
            'products' => OrderProductResource::collection($this->whenLoaded('order_products')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'total' => $this->total,
            'user' => $this->data->user,
            'created_at' => $this->created_at,
            'createdAtRelative' => $this->when($this->created_at, function () {
                return $this->created_at->locale('es_ES')->diffForHumans(['parts' => 1]);
            }),
        ];
    }
}
