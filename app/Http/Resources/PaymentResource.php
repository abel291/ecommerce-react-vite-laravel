<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'method' => $this->method->getLabel(),
            'method_color' => $this->method->getColor(),
            'data' => $this->data,
            'code_reference' => $this->code_reference,
        ];
    }
}
