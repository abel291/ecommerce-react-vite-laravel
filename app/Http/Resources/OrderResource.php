<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public static $wrap = 'data';
    public function toArray($request)
    {
        return [
            'code' => $this->code,
            'quantity' => $this->quantity,
            'shipping' => $this->shipping,
            'tax_amount' => $this->tax_amount,
            'tax_percent' => $this->tax_percent,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'user_data' => $this->user_json,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'products' => PaidProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
