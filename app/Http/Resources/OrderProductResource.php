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
            'product' => new ProductResource($this->product),
            'recieved_at' => $this->recieved_at,
            'volume' => $this->volume,
            'price' => $this->price,
            'price_total' => $this->volume * $this->price
        ];
    }
}
