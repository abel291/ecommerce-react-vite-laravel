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
            'status' => $this->status->text(),
            'status_color' => $this->status->color(),
            'method' => $this->method->text(),
            'method_color' => $this->method->color(),
            'data' => $this->data,
            'code_reference' => $this->code_reference,

        ];
    }
}
