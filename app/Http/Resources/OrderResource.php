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
        $ordered_products = OrderProductResource::collection($this->orderProducts);

        return [
            'ordered_at' => $this->ordered_at,
            'user' => $this->user->name,
            'completed' => $this->status(),
            'ordered_products' => $ordered_products,
            'order_price' => $ordered_products->sum(function($product){
                return $product->price * $product->volume;
            }),
            'note' => $this->note
        ];
    }
}
